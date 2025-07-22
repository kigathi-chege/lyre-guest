<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LoginListener
{
    /**
     * Create the event listener.
     */
    public function __construct(\Illuminate\Auth\Events\Login $event)
    {
        logger("useer has logged in!!!", [$event]);
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        //
    }
}
