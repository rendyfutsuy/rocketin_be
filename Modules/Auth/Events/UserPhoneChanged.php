<?php

namespace Modules\Auth\Events;

use Modules\Auth\Models\User;
use Modules\Auth\Models\ResetPhone;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserPhoneChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    public $user;

    /** @var string */
    public $newPhone;

    /** @var string */
    public $oldPhone;

    /** @var \Modules\Auth\Models\ResetPhone */
    public $phoneReset;

    /**
     * Create a new event instance.
     *
     * @param  string  $oldPhone
     * @param  string  $newPhone
     * @return void
     */
    public function __construct(User $user, $oldPhone, $newPhone)
    {
        $phoneReset = $user->resetPhones()->first();

        $this->user = $user;
        $this->phoneReset = $phoneReset;
        $this->oldPhone = $oldPhone;
        $this->newPhone = $newPhone;
    }

    /**
     * Get old user data.
     *
     * @return string
     */
    public function getOldData()
    {
        return $this->oldPhone;
    }

    /**
     * Get new user data.
     *
     * @return string
     */
    public function getNewData()
    {
        return $this->newPhone;
    }

    /**
     * Get user.
     *
     * @return \Modules\Auth\Models\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
