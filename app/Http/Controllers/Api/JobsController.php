<?php

namespace App\Http\Controllers\Api;

use Exception;
use App\Models\Job;
use App\Models\User;
use App\Enums\JobStatus;
use App\Models\JobFiles;
use App\Enums\PriorityType;
use App\Models\JobPriority;
use App\Mail\AdminJobCreate;
use App\Mail\AdminJobUpdate;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\PriorityTypeCheck;
use App\Events\SendJobCreateEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\JobsResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\JobCollection;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use App\Events\ProcessCallToTechnician;
use Spatie\QueryBuilder\AllowedInclude;
use Symfony\Component\HttpFoundation\Response;

class JobsController extends Controller
{
	public function index(Request $request)
	{	
		$notificationsCount =  Notification::where(['user_id' => Auth::id(), 'is_read' => 0])->count();
		
		$data = QueryBuilder::for(Job::class)
		->allowedIncludes(['priority', 'assets.assetType', AllowedInclude::relationship('attachments', 'file')])
		->allowedFilters([
			AllowedFilter::partial('name', 'job_name'),
			AllowedFilter::exact('priority_id', 'job_priority_id'),
			AllowedFilter::exact('status')
			])
			->allowedSorts(['created_at', 'updated_at', 'due_at'])
			->defaultSort('-due_at')
			->with(['priority'])
			->visibleTo(Auth::user())
			->paginate();
			
		return JobsResource::collection($data)->additional([
			'meta' => [
				'notification_count' => $notificationsCount
			]
		]);
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
            'name' => ['required', 'max:255'],
            'priority_id' => ['required', 'integer', Rule::exists('job_priorities', 'id')],
            'availability' => [
				Rule::excludeIf(function() use ($request) {
					$type = JobPriority::select('type')->where(['id' => $request->priority_id])->first();
					return ($type->type->value === PriorityType::CRITICAL->value);
				}), 'required', 'max:255'],
            'description' => ['required'],
            'asset_id' => ['required', 'integer', Rule::exists('assets', 'id')],
            'attachments.*' => ['file', 'mimetypes:image/jpg,image/jpeg,image/png,image/svg,image/webp,video/quicktime']
        ]);

		try {
			$job = DB::transaction(function ($query) use ($request, $validated) {
				$job = Job::create([
					'job_name' => $validated['name'],
					'job_priority_id' => $validated['priority_id'],
					'availability' => $validated['availability'] ?? null,
					'job_description' => $validated['description'],
					'user_id' => Auth::id()
				]);

				$job->assets()->attach($validated['asset_id']);
		
				foreach ($request->attachments ?? [] as $photo) {
					$filename = $photo->store('photos');
					JobFiles::create([
						'job_id' => $job->id,
						'file_name' => $filename,
						'file_type' => $photo->getMimeType(),
						'file_size' => $photo->getSize()
					]);
				}
	
				return $job;
			});

			$job->refresh();
			$job->load(['priority', 'assets', 'file']);
			
			$type = JobPriority::select('type')->where(['id' => $request->priority_id])->first();
			if ($type->type->value === PriorityType::CRITICAL->value) event(new ProcessCallToTechnician($job->id));

			$admin = User::where(['user_role' => 1])->first();

			// job date
			$date = strtotime($job->created_at);

        	$mailData = [
            	'title' => 'Mail from ARE Services',
				'name' => $admin['name'],
				'jobName' => $job->job_name,
				'jobDate' => date('M d, Y',$date),
				'location' => $job->assets[0]->location,
				'brand_name' => $job->assets[0]->brand_name,
				'serial' => $job->assets[0]->serial,
        	];
			
        	Mail::to($admin->email)
            	->send(new AdminJobCreate($mailData));

			return JobsResource::make($job);
		} catch (Exception $ex) {
			Log::info('Error when create a job'. $ex->getMessage());
			return response()->json($ex->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
		}
	}

	public function show(Job $job)
	{
		Gate::authorize('view', $job);
		
		$job->load(['priority', 'assets.assetType', 'file']);
		
		return new JobsResource($job);
	}

	public function update(Request $request, Job $job)
	{
		Gate::authorize('update', $job);
		
		$validated = $request->validate([
			'name' => ['required', 'max:255'],
			'availability' => [
				Rule::excludeIf(function() use ($request) {
					$type = JobPriority::select('type')->where(['id' => $request->priority_id])->first();
					return ($type->type->value === PriorityType::CRITICAL->value);
				}), 'required', 'max:255'],
			'description' => ['required'],
			'status' => ['sometimes', 'required', Rule::in([JobStatus::OPEN->value, JobStatus::CANCELLED->value])],
			'attachments.*' => ['file', 'mimetypes:image/jpg,image/jpeg,image/png,image/svg,image/webp,video/quicktime']
		]);
		
		try {
			DB::transaction(function ($query) use ($request, $job, $validated) {
				$job->fill([
					'job_name' => $validated['name'],
					'availability' => $validated['availability'] ?? '',
					'job_description' => $validated['description'],
					'status' => $validated['status'] ?? JobStatus::OPEN
				]);
				
				$job->update();
	
				foreach ($request->attachments ?? [] as $photo) {
					$filename = $photo->store('photos');
					JobFiles::create([
						'job_id' => $job['id'],
						'file_name' => $filename,
						'file_type' => $photo->getMimeType(),
						'file_size' => $photo->getSize()
					]);
				}
			});

			if (!empty($validated['availability'])) {
				$admin = User::where(['user_role' => 1])->first();

			// job date
			$date = strtotime($job->updated_at);

        		$mailData = [
					'title' => 'Mail from ARE Services',
					'name' => $admin['name'],
					'jobName' => $job->job_name,
					'jobDate' => date('M d, Y',$date),
					'location' => $job->assets[0]->location,
					'brand_name' => $job->assets[0]->brand_name,
					'serial' => $job->assets[0]->serial,
				];

        		Mail::to($admin->email)
            		->send(new AdminJobUpdate($mailData));
			}

			return response()->json(null, 204);
		}
		catch (Exception $ex) {
			return response()->json($ex->getMessage(), 500);
		}
	}
}