<?php

namespace Modules\Auth\Listeners;

use Modules\Auth\Models\UserActivity;
use Illuminate\Auth\Events\Registered;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class LogSuccessfulRegistration
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
     * @param  \Illuminate\Auth\Events\Registered  $registered
     * @return void
     */
    public function handle(Registered $registered)
    {
        $registered->user->recordLastOnline();

        $this->recordActivity
            ->save(
                UserActivity::REGISTER,
                UserActivity::ACTIVITY,
                $registered->user->id
            );
    }
}
