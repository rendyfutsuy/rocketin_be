<?php

namespace Modules\Admin\Http\Controllers;

use Modules\Auth\Models\User;
use App\Http\Controllers\Controller;
use Modules\Admin\Http\Resources\UserDetail;

class ShowDetailUser extends Controller
{
    public function __invoke(User $user)
    {   
        return new UserDetail($user);
    }
}
