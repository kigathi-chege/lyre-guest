<?php

namespace Lyre\Guest\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Events\Dispatcher;

// TODO: Kigathi - August 14 2025 - We can use this to track user sessions

class UserEventSubscriber
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle user login events.
     */
    public function handleUserLogin(\Illuminate\Auth\Events\Login $event): void
    {
        // $request = request();

        // logger("USER LOGGED IN!", [auth()->user()->toArray()]);
        // // dd($request);
        // $guestUuid = retrieve_guest_uuid($request);
        // logger("USER LOGGED IN!", [$event, $request]);
        after_login($event->user, request());
    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout(\Illuminate\Auth\Events\Logout $event): void
    {
        after_logout($event->user, request());
    }

    /**
     * Handle user registered events.
     */
    public function handleUserRegistered(\Illuminate\Auth\Events\Registered $event): void
    {
        after_register($event->user, request());
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            \Illuminate\Auth\Events\Login::class => 'handleUserLogin',
            \Illuminate\Auth\Events\Logout::class => 'handleUserLogout',
            \Illuminate\Auth\Events\Registered::class => 'handleUserRegistered',
        ];
    }
}
