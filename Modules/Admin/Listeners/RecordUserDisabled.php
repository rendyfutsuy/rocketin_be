<?php

namespace Modules\Admin\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Admin\Events\UserUpdated;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordUserDisabled
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
     * @param  UserUpdated  $userUpdate
     * @return void
     */
    public function handle(UserUpdated $userUpdate)
    {
        if (empty($userUpdate->request->is_banned)) {
            return;
        }

        $this->recordActivity
            ->setOldData([
                'user_id' => $userUpdate->user->id,
                'banned_at' => null,
            ])
            ->setNewData([
                'user_id' => $userUpdate->user->id,
                'banned_at' => now(),
            ])
            ->withDetails()
            ->save(
                UserActivity::ADMIN_USER_DISABLED,
                UserActivity::ADMIN,
                $userUpdate->admin->id
            );
    }
}
