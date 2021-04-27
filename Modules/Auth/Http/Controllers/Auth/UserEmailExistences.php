<?php

namespace Modules\Auth\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use App\Http\Controllers\Controller;

class UserEmailExistences extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $user = User::whereEmail($request->email)
            ->whereNotNull('email')->first();

        if (! $user) {
            return response()->json([
                'message' => 'Email Bisa dipakai..'
            ], 200);
        }

        return response()->json([
            'data' => [
                'email' => $user->email,
            ],
            'message' => 'Email Tidak Bisa dipakai..'
        ], 403);
    }
}
