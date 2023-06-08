<?php

namespace App\Listeners;

use App\Notifications\PasswordUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendPasswordUpdatedNotification
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
    public function handle(object $event): void
    {
        $event->user->SendPasswordUpdatedNotification();
    }
}
