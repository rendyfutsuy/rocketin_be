<?php

namespace Modules\Auth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use App\Http\Controllers\Controller;

class UsernameExistences extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $user = User::whereUsername($request->username)
            ->whereNotNull('username')->first();

        if (! $user) {
            return response()->json([
                'message' => 'Username Bisa dipakai..'
            ], 200);
        }

        return response()->json([
            'data' => [
                'username' => $user->username,
            ],
            'message' => 'Username Tidak Bisa dipakai..'
        ], 403);
    }
}
