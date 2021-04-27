<?php

namespace Modules\Profile\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class AvatarUploaded
{
    use SerializesModels;

    /**
     * The authenticated user.
     *
     * @var \Modules\Auth\Models\User
     */
    public $user;

    /**
     * The authenticated user.
     *
     * @var string
     */
    public $avatar;

    /**
     * Create a new event instance.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return void
     */
    public function __construct($user, ?string $avatar)
    {
        $this->user = $user;
        $this->avatar = $avatar;
    }
}
