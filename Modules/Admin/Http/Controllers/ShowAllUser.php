<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use App\Http\Controllers\Controller;
use Modules\Admin\Http\Searches\UserListSearch;
use Modules\Admin\Http\Resources\UserCollection;

class ShowAllUser extends Controller
{
    public function __invoke(Request $request)
    {   
        $users = app()->make(UserListSearch::class)
            ->apply()
            ->where('id', '<>', auth()->id())
            ->paginate($request->per_page ?? 5);

        return new UserCollection($users);
    }
}
