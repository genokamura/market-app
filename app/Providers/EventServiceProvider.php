<?php

namespace App\Providers;

use App\Events\EmailAddressChanged;
use App\Events\FullRegistered;
use App\Events\PasswordUpdated;
use App\Listeners\SendEmailAddressChangedNotification;
use App\Listeners\SendFullRegistrationNotification;
use App\Listeners\SendPasswordUpdatedNotification;
use Illuminate\Auth\Events\Registered;
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
        FullRegistered::class => [
            SendFullRegistrationNotification::class,
        ],
        EmailAddressChanged::class => [
            SendEmailAddressChangedNotification::class,
        ],
        PasswordUpdated::class => [
            SendPasswordUpdatedNotification::class,
        ],
        EmailUpdateVerified::class => [
            SendEmailUpdateVerifiedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
