<?php

namespace Modules\Auth\Events;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;
use Modules\Auth\Models\EmailReset;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewEmailRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    public $user;

    /** @var \Modules\Auth\Models\EmailReset */
    public $emailReset;

    /**
     * Create a new event instance.
     *
     * @param  \Modules\Auth\Models\EmailReset  $emailReset
     */
    public function __construct(User $user, $emailReset)
    {
        $this->user = $user;
        $this->emailReset = $emailReset;
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
