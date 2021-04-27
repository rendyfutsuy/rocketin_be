<?php

namespace Modules\Profile\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Profile\Events\ProfileUpdated;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordFullNameLog
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

        if ($profile->request->full_name == null) {
            return;
        }

        $this->recordActivity
            ->setOldData($profile->user->full_name)
            ->setNewData($profile->request->full_name)
            ->withDetails()
            ->save(
                UserActivity::PROFILE_FULL_NAME_UPDATED,
                UserActivity::BIODATA,
                $profile->user->id
            );
    }
}

