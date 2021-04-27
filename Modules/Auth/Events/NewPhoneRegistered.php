<?php

namespace Modules\Auth\Events;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;
use Modules\Auth\Models\ResetPhone;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class NewPhoneRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var \Modules\Auth\Models\User */
    public $user;

    /** @var \Modules\Auth\Models\ResetPhone */
    public $phoneReset;

    /**
     * Create a new event instance.
     *
     * @param  \Modules\Auth\Models\ResetPhone  $phoneReset
     */
    public function __construct(User $user, $phoneReset)
    {
        $this->user = $user;
        $this->phoneReset = $phoneReset;
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
