<?php

namespace Modules\Auth\Events;

use Modules\Auth\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserEmailChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    public $user;

    /** @var string */
    public $newEmail;

    /** @var string */
    public $oldEmail;

    /** @var \Modules\Auth\Models\EmailReset */
    public $emailReset;

    /**
     * Create a new event instance.
     *
     * @param  string  $oldEmail
     * @param  string  $newEmail
     * @return void
     */
    public function __construct(User $user, $oldEmail, $newEmail)
    {
        $emailReset = $user->resetEmails()->first();

        $this->user = $user;
        $this->emailReset = $emailReset;
        $this->oldEmail = $oldEmail;
        $this->newEmail = $newEmail;
    }

    /**
     * Get old user data.
     *
     * @return string
     */
    public function getOldData()
    {
        return $this->oldEmail;
    }

    /**
     * Get new user data.
     *
     * @return string
     */
    public function getNewData()
    {
        return $this->newEmail;
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
