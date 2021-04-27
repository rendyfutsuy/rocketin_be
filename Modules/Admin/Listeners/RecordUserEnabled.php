<?php

namespace Modules\Admin\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Admin\Events\UserUpdated;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordUserEnabled
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
        if ($userUpdate->request->is_banned) {
            return;
        }

        $this->recordActivity
            ->setOldData([
                'user_id' => $userUpdate->user->id,
                'banned_at' => $userUpdate->user->banned_at,
            ])
            ->setNewData([
                'user_id' => $userUpdate->user->id,
                'banned_at' => null,
            ])
            ->withDetails()
            ->save(
                UserActivity::ADMIN_USER_ENABLED,
                UserActivity::ADMIN,
                $userUpdate->admin->id
            );
    }
}
