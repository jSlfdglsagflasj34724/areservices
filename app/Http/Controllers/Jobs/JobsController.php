<?php

namespace App\Http\Controllers\Jobs;

use Exception;
use App\Models\Job;
use App\Mail\Status;
use App\Enums\JobStatus;
// use App\Traits\Firebase;
use App\Models\Notification;
use App\Services\FCMService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Events\PushNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

class JobsController extends Controller
{
    // use Firebase;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $status = $request->status ?? 'open';
        
        $data = [
            'jobsdetail' => Job::where(['status' => $status])->orderBy('id' ,'DESC')->with(['priority', 'assignedTechnician.technician', 'assets.assetType'])->get(),
            'status' => $status
        ];
        
        return view('dashboard/jobs/jobsdetail', $data);
    }

    public function show(Job $job)
    {
        $data = $job->load(['priority', 'file']);
        
        return view('dashboard/jobs/jobDetails', compact('data'));
    }

    public function update(Request $request, Job $job)
    {
        try {
            $data = DB::transaction(function ($query) use ($request, $job) {
                $job->load('user');
                $job->fill($request->only('status'));
                $job->update();

                $name = $job->job_name ?? '';
                
                $notification = $this->getNotificationMessage($request->status, $name);
                
                $notificationCreate = Notification::create([
                    'user_id' => $job->user->id,
                    'job_id' => $job->id,
                    'is_read' => 0,
                    'notification' => $notification,
                ]);

                return $notificationCreate;
            });
            
            // trigger event if user has fcm token to send push notification
            $fcm_token = $job->user->fcm_token;
            $badge = Notification::where(['user_id' => $job->user_id, 'is_read' => 0])->count();
            $pushNotification = [];
            if ($fcm_token != null) $pushNotification = $this->sendNotification($data, $badge, $request->status, $fcm_token);
            if ($pushNotification != []) Notification::where(['id' => $data->id])->update(['status' => 1]);

            $mailData = [
                'name' => $job->job_name,
                'status' => $request['status'],
                'title' => 'Job Status Changed',
            ];

            Mail::to($job->user->email)
                ->send(new Status($mailData));

            $request->session()->flash('alert-success', 'Job Status is successful updated!');
        
            return redirect()->to('/jobs');
        } catch (Exception $ex) {
            Log::info('Error message while updating job:'. $job->job_name .'::{'.$ex->getMessage().'}');
            $request->session()->flash('alert-danger', 'Something went wrong!');
        
            return redirect()->to('/jobs');
        }
    }
    
    public function getNotificationMessage($status, $name)
    {
        $text = ($status == 'cancelled') ? 'Unfortunately' : 'Congratuliation';
        $notification = $text.'! Your job ' .$name. ' has been successfully ' . $status;
        
        return $notification;
    }

    public function sendNotification($data, $badge, $status, $fcm_token){
        $notification = [
            'title' =>'Are Services',
            'body' => $data->notification,
            'badge' => $badge,
        ];

        $fcmNotification = [
            'to'        => $fcm_token, //single token
            'notification' => $notification,
        ];
        
        return FCMService::send($fcmNotification);
    }
}    