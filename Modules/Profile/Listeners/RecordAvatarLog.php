<?php

namespace Modules\Profile\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Profile\Events\AvatarUploaded;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordAvatarLog
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
    public function handle(AvatarUploaded $profile)
    {
        $profile->user->recordLastOnline();

        if ($profile->avatar == null) {
            return;
        }

        $this->recordActivity
            ->setOldData($profile->user->avatar)
            ->setNewData($profile->avatar)
            ->withDetails()
            ->save(
                UserActivity::PROFILE_AVATAR_UPDATED,
                UserActivity::BIODATA,
                $profile->user->id
            );
    }
}

