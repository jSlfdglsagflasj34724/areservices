<?php

namespace App\Http\Controllers\Technicians;

use Exception;
use App\Models\Job;
use App\Models\User;
use App\Mail\CustomerMail;
use App\Models\Technicians;
use App\Mail\TechnicianMail;
use App\Models\Notification;
use App\Services\FCMService;
use Illuminate\Http\Request;
use App\Models\JobTechnician;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class AssignTechnicianController extends Controller
{
    public function index(Job $job)
    { 
        $data = [
            'technicians' => User::orderBy('id', 'DESC')->where(['user_role' => 3, 'status' => 1])->with('technician.usersData')->get(),
            'job' => $job
        ];
        
        $job_technician = JobTechnician::where(['job_id' => $job->id, 'is_assigned' => 1])->with('technician')->first();
        
        $data['job_technician'] = $job_technician ?? null;
        
        return view('dashboard/jobs/assignTechnician', $data);
    }

    public function store(Request $request, Job $job)
    {
        $date = date('Y-m-d');
        
        $validated = $request->validate([
            'technician' => ['required'],
            'date' => ['required', 'after_or_equal:'.$date],
        ]);
        
        $job->load('user');

        try {
            DB::transaction(function ($query) use ($validated, $job) {
    
                $jobTechnician = JobTechnician::where([
                    'job_id' => $job->id,
                    'is_assigned' => 1
                ])->update([
                    'is_assigned' => 0
                ]);
    
                JobTechnician::create([
                    'job_id' => $job->id,
                    'technican_id' => $validated['technician'],
                    'date' => $validated['date'],
                    'is_assigned' => 1,
                ]);
                
            });
            
            $technicianName = User::where(['id' => $request['technician']])->with('usersData')->first();
            $notification = 'A new technician '. $technicianName->name .' has been assigend to your ' .$job->job_name. ' job';

            $notificationCreate = Notification::create([
                'user_id' => $job->user->id,
                'job_id' => $job->id,
                'is_read' => 0,
                'notification' => $notification,
            ]);
            
            
            // trigger event if user has fcm token to send push notification
            $fcm_token = $job->user->fcm_token;
            $badge = Notification::where(['user_id' => $job->user_id, 'is_read' => 0])->count();
            $pushNotification = [];
            if ($fcm_token != null) $pushNotification = $this->sendNotification($notification, $badge, $job->status->value, $fcm_token);
            
            if ($pushNotification != []) Notification::where(['id' => $notificationCreate->id])->update(['status' => 1]);
            
            // job date
			$date = strtotime($job->created_at);

            $mailData = [
                'title' => 'Mail from ARE Services',
                'name' => $technicianName['name'],
                'date' => $validated['date'],
                'jobName' => $job['job_name'],
                'jobDate' => date('M d, Y',$date),
            ];
            
            Mail::to($technicianName->email)
                ->send(new TechnicianMail($mailData));

            Mail::to($job->user->email)
                ->send(new CustomerMail($mailData));

            $request->session()->flash('alert-success', 'Technician successful assigned!');
        
            return redirect()->to('/jobs');
        } catch (Exception $ex) {
            Log::info('Error in assigning technician to job:' . $ex->getMessage());
            $request->session()->flash('alert-danger', 'Something went wrong!');
        
            return redirect()->to('/jobs');
        }
    }

    public function sendNotification($data, $badge, $status, $fcm_token){
        $notification = [
            'title' =>'Are Services',
            'body' => $data,
            'badge' => $badge,
        ];

        $fcmNotification = [
            'to'        => $fcm_token, //single token
            'notification' => $notification,
        ];
        
        return FCMService::send($fcmNotification);
    }
}
