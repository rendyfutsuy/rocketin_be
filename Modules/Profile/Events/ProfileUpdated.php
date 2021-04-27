<?php

namespace Modules\Profile\Events;

use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class ProfileUpdated
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
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Modules\Auth\Models\User  $user
     * @return void
     */
    public function __construct($user, Request $request)
    {
        $this->user = $user;
        $this->request = $request;
    }
}
