<?php

namespace Modules\Auth\Listeners;

use Modules\Auth\Models\UserActivity;
use Illuminate\Auth\Events\Logout;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class LogSuccessfulLogout
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
     * @param  \Illuminate\Auth\Events\Logout  $logout
     * @return void
     */
    public function handle(Logout $logout)
    {
        if (empty($logout->user)) {
            return;
        }

        $this->recordActivity->save(
            UserActivity::LOGOUT,
            UserActivity::ACTIVITY,
            $logout->user->id
        );
    }
}