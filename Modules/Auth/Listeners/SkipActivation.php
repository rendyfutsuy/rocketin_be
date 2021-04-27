<?php

namespace Modules\Auth\Listeners;

use Modules\Auth\Listeners\SkipActivation;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Auth\Events\Registered;

class SkipActivation
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $registered
     * @return void
     */
    public function handle(Registered $registered)
    {
        if (Config::get('auth.skip_activation')) {
            $registered->user->markEmailAsVerified();
        }
    }
}
