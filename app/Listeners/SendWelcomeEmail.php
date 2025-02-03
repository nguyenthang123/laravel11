<?php

namespace App\Listeners;

use App\Events\UserRegister;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;


class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        log::debug(1222);
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegister $event): void
    {
        log::debug(111);
        log::debug($event->user->email);
    }
}
