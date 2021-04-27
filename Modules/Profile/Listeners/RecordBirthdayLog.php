<?php

namespace Modules\Profile\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Profile\Events\ProfileUpdated;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordBirthdayLog
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

        if ($profile->request->birthday == null) {
            return;
        }

        $this->recordActivity
            ->setOldData($profile->user->birthday)
            ->setNewData($profile->request->birthday)
            ->withDetails()
            ->save(
                UserActivity::PROFILE_BIRTHDAY_UPDATED,
                UserActivity::BIODATA,
                $profile->user->id
            );
    }
}

