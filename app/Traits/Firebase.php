<?php


namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait Firebase
{

    public  function firebaseNotification($fcmNotification)
    {
        // $apiKey = config('fcm.token');
        // dd($apiKey);
        // $http = Http::withHeaders([
        //      'Authorization:key' => $apiKey,
        //      'Content-Type' => 'application/json'
        //     ])->post('https://fcm.googleapis.com/fcm/send', $fcmNotification);

            $http = Http::acceptJson()->withToken(config('fcm.token'))->post(
                'https://fcm.googleapis.com/fcm/send', $fcmNotification
            );
            dd($http);;
        return  $http->json();
    }
}