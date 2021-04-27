<?php

namespace Modules\Auth\ServiceManagers;

use Modules\Auth\Models\UserActivity;

class RecordActivityManager
{
    /** @var string|int|null */
    protected $oldData;

    /** @var string|int|null */
    protected $newData;

    /** @var UserActivity */
    protected $activity;

    /** @var string|object|int */
    protected $details;

    /** @var bool */
    protected $isOutlet = false;

    /**
     * @return void
     */
    public function __construct(UserActivity $userActivity)
    {
        $this->activity = $userActivity;
    }

    /**
     * @param  int  $activityCode
     * @param  int  $type
     * @param  int  $userId
     * @return void
     */
    public function save($activityCode, $type, $userId)
    {
        if ($this->shouldNotRecord()) {
            return;
        }

        $this->activity->user_id = $userId;
        $this->activity->type = $type;
        $this->activity->activity_code = $activityCode;
        $this->activity->details = $this->details;
        $this->activity->save();
    }

    /**
     * @param  int|string|null  $oldData
     * @return self
     */
    public function setOldData($oldData)
    {
        $this->oldData = $oldData;

        return $this;
    }

    /**
     * @param  int|string|null  $newData
     * @return self
     */
    public function setNewData($newData)
    {
        $this->newData = $newData;

        return $this;
    }

    /**
     * @param  int|string|null  $details
     * @return self
     */
    public function withDetails($details = null)
    {
        $this->details = $details;

        if (! $details) {
            $this->details = (object) [
                'old_data' => $this->oldData,
                'new_data' => $this->newData,
            ];
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function shouldNotRecord()
    {
        if ($this->newData && $this->oldData) {
            return $this->newData == $this->oldData;
        }

        return false;
    }
}
