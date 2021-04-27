<?php

namespace Modules\Admin\Events;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Queue\SerializesModels;

class NewAdminRegistered
{
    use SerializesModels;

    /**
     * @var User
     */
    public $admin;

    /**
     * @var User
     */
    public $newAdmin;

    /**
     * @var Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $admin, User $newAdmin, Request $request)
    {
        $this->admin = $admin;
        $this->newAdmin = $newAdmin;
        $this->request = $request;
    }
}
