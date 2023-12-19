<?php

namespace App\Services;

use Exception;
use GuzzleHttp\Client;
use App\Models\Notification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class FCMService
{ 
    public static function send($fcmNotification)
    {
        try {
            $response = Http::withHeaders([
                    'Authorization' => config('fcm.token')
                ])
                ->withBody(json_encode($fcmNotification), 'application/json')
                ->post('https://fcm.googleapis.com/fcm/send');

            $response->throw();
            Log::info($response);
            if ($response->successful()) {
                return response()->json();
            }

            return [];            
        } catch(Exception $e) {
            return [];
        }
    }
}