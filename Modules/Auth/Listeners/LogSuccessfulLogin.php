<?php

namespace Modules\Auth\Listeners;

use Modules\Auth\Models\UserActivity;
use Illuminate\Auth\Events\Login;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class LogSuccessfulLogin
{
    /** @var RecordActivityManager */
    public $recordActivity;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(RecordActivityManager $recordActivity)
    {
        $this->recordActivity = $recordActivity;
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Login  $login
     * @return void
     */
    public function handle(Login $login)
    {
        $login->user->recordLastOnline();
        
        $this->recordActivity
            ->save(
                UserActivity::LOGIN,
                UserActivity::ACTIVITY,
                $login->user->id
            );
    }
}

