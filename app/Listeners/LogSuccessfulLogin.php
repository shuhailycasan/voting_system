<?php

namespace App\Listeners;

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Spatie\Activitylog\Facades\LogBatch;
use Spatie\Activitylog\Traits\LogsActivity;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class LogSuccessfulLogin
{

    public function __invoke(Login $event)
    {
        activity('auth')
            ->causedBy($event->user)
            ->withProperties([
                'ip' => request()->ip(),
                'agent' => request()->userAgent(),
            ])
            ->log('User logged in');
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
