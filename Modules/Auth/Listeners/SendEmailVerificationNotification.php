<?php

namespace Modules\Auth\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification as ParentEvent;

class SendEmailVerificationNotification extends ParentEvent
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ($event->user->email != null) {
            parent::handle($event);
        }
    }
}
