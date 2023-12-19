<?php

namespace App\Http\Controllers;

use App\Events\ProcessCallToTechnician;
use App\Models\JobTechnician;
use App\Models\OffHoursTechnician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Twilio\TwiML\VoiceResponse;
use Twilio\Rest\Client;

class TwilioController extends Controller
{
    protected $account_sid; 
    protected $auth_token;
    protected $twilio_number; 

    public function __construct()
    {
        $this->account_sid = getenv('TWILIO_SID');
        $this->auth_token = getenv('TWILIO_AUTH_TOKEN');
        $this->twilio_number = getenv('TWILIO_NUMBER');
    }

    public function status(Request $request, $id){
        if ($request['CallStatus'] == 'no-answer' || $request['CallStatus'] == 'busy') {
            $this->callAgainToTechnician($id);
        }
    }

    public function gather(Request $request, $id) {
            Log::info([$request['CallStatus']]);
            Log::info($request->all());

            $response = new VoiceResponse();
    
            switch ($request['Digits']) {
            case 1:
                $response->say('Thank you for accepting the job');
                $this->assignTechnicianToJob($id);
                break;
            case 2:
                $response->say('You have declined the job. Thank you');
                $this->processCallToAdmin();
                break;
            default:
                $response->say('Sorry, I don\'t understand that choice.');
            }
    
            header('Content-Type: text/xml');
            echo $response;
    }

    public function assignTechnicianToJob($job_id)
    {
        DB::transaction(function ($query) use ($job_id) {
            $offHoursTechnician = OffHoursTechnician::first();
            
            JobTechnician::create([
                'job_id' => $job_id,
                'technican_id' => $offHoursTechnician->technican_id,
                'date' => date('Y-m-d'),
                'is_assigned' => 1,
            ]);

            OffHoursTechnician::where(['id' => $offHoursTechnician->id])
                                ->update(['numberOfCalls' => 0]);
        });
    }

    public function processCallToAdmin()
    {
        $admin = User::where(['user_role' => 1])->with(['country'])->first();

        $number = '+'.$admin->country->phonecode.$admin->phone_number;

        $client = new Client($this->account_sid, $this->auth_token);

        $client->account->calls->create(
            $number,
            $this->twilio_number,
            [
                'method' => 'GET',
                'statusCallback' => "https://areservices.appexperts.us/callstatus",
                'statusCallbackMethod' => 'POST',
                'twiml' => "<Response>
                <Say>'A new urgent job has been generated, which is not accepted by the technician, please have a look at it. Thank you'</Say>
                </Response>",
            ], );
    }

    public function callAgainToTechnician($job_id)
    {
        $numberOfCalls = OffHoursTechnician::first();

        if ($numberOfCalls->numberOfCalls != 2) {
            OffHoursTechnician::where(['id' => $numberOfCalls->id])
                                ->update(['numberOfCalls' => $numberOfCalls->numberOfCalls + 1]);
            
            event(new ProcessCallToTechnician($job_id));
        } elseif ($numberOfCalls->numberOfCalls == 2) {
            OffHoursTechnician::where(['id' => $numberOfCalls->id])
                                ->update(['numberOfCalls' => 0]);
            $this->processCallToAdmin();
        }
    }
}
