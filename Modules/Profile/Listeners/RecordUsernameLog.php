<?php

namespace Modules\Profile\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Profile\Events\ProfileUpdated;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordUsernameLog
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
    public function handle(ProfileUpdated $profile)
    {
        $profile->user->recordLastOnline();

        if ($profile->request->username == null) {
            return;
        }

        $this->recordActivity
            ->setOldData($profile->user->username)
            ->setNewData($profile->request->username)
            ->withDetails()
            ->save(
                UserActivity::PROFILE_USERNAME_UPDATED,
                UserActivity::BIODATA,
                $profile->user->id
            );
    }
}

