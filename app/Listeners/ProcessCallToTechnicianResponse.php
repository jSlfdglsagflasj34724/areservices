<?php

namespace App\Listeners;

use App\Events\ProcessCallToTechnician;
use App\Models\OffHoursTechnician;
use App\Models\User;
use Twilio\Rest\Client;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessCallToTechnicianResponse
{
    /**
     * Create the event listener.
     */

    protected $account_sid; 
    protected $auth_token;
    protected $twilio_number; 

    public function __construct()
    {
        $this->account_sid = getenv('TWILIO_SID');
        $this->auth_token = getenv('TWILIO_AUTH_TOKEN');
        $this->twilio_number = getenv('TWILIO_NUMBER');
    }

    /**
     * Handle the event.
     */
    public function handle(ProcessCallToTechnician $event): void
    {
        $offHourstechnician = OffHoursTechnician::where(['status' => 1])->with(['technician.country_code'])->first();
        
        if ($offHourstechnician == null) {
            $admin = User::where(['user_role' => 1])->with(['country'])->first();
            $number = '+'.$admin->country->phonecode.$admin->phone_number;
            $message = 'A new urgent job has been generated, please have a look at it. Thank you';
        } else {
            $number = '+'.$offHourstechnician->technician->country_code->phonecode.$offHourstechnician->technician->phone_no;
            $message = 'You have been assigned a new urgent job.Please click 1 to accept or 2 to decline';
        }
        
        $id = $event->job_id;
        $client = new Client($this->account_sid, $this->auth_token);
        $client->account->calls->create(
            $number,
            $this->twilio_number,
            [
                'method' => 'GET',
                'statusCallback' => "https://areservices.appexperts.us/callstatus/".$id."",
                'statusCallbackMethod' => 'POST',
                'twiml' => "<Response>
                <Say>".$message."</Say>
                <Gather numDigits='1' timeout='10' action = 'https://areservices.appexperts.us/gatherResponse/".$id."' method = 'post'>
                </Gather>
                </Response>",
            ], );
    }
}
