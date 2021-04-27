<?php

namespace Modules\Admin\Events;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Queue\SerializesModels;

class UserUpdated
{
    use SerializesModels;

    /**
     * @var User
     */
    public $admin;

    /**
     * @var User
     */
    public $user;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $admin, User $user, Request $request)
    {
        $this->admin = $admin;
        $this->user = $user;
        $this->request = $request;
    }
}
