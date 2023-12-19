<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Services\FCMService;
use App\Events\PushNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPushNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PushNotification $event): void
    {
        $response = FCMService::send(
                $event->fcm_token,
                [
                    'title' => 'Are Services',
                    'body' => $event->notification->notification,
                ],
                $event->notification,
                [
                    'badge' => Notification::where(['user_id' => $event->notification->user_id, 'is_read' => 0])->count(),
                    'status' => $event->status
                ]
            );
    }
}