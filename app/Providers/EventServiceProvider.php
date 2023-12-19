<?php

namespace App\Providers;

use App\Events\TwilioProcessed;
use App\Events\PushNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use App\Events\ProcessCallToTechnician;
use App\Listeners\SendPushNotification;
use App\Listeners\ProcessCallToTechnicianResponse;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        ProcessCallToTechnician::class => [
            ProcessCallToTechnicianResponse::class,
        ],
        PushNotification::class => [
            SendPushNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(
          TwilioProcessed::class,
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
