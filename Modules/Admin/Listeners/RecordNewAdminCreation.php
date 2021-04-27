<?php

namespace Modules\Admin\Listeners;

use Modules\Auth\Models\UserActivity;
use Modules\Admin\Events\NewAdminRegistered;
use Modules\Auth\ServiceManagers\RecordActivityManager;

class RecordNewAdminCreation
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
     * @param  NewAdminRegistered  $adminRegistered
     * @return void
     */
    public function handle(NewAdminRegistered $adminRegistered)
    {
        // 
    }
}
