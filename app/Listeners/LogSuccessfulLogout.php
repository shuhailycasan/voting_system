<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class LogSuccessfulLogout
{

    public function __invoke(Logout $event)
    {
        activity('auth')
            ->causedBy($event->user)
            ->withProperties([
                'ip' => request()->ip(),
                'agent' => request()->userAgent(),
            ])
            ->log('User logged out');
    }


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
        //
    }
}
