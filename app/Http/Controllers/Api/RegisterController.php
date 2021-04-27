<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Config;
use Modules\Message\ServiceManager\Message;
use App\Http\Controllers\CustomAuth\CustomRegistration;

class RegisterController extends CustomRegistration
{
    /**
     * Register new user from mobile app.
     *
     * @return \Illuminate\Http\JsonResponse
     * 
     * @throws \Exception
     */
    public function __invoke(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $this->validator($request->all())->validate();
    
            $user = $this->create($request->all());
    
            // event(new Registered($user));
        
            // $this->sendOtpCode($user);
    
            return $this->responseMessage(
                self::SUCCESS,
                $this->translate('auth::registration.success', $this->getLocale($request)),
                200
            ); 
        });
    }

    protected function myRules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:128',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED);
                }),
            ],
            'email' => [
                'sometimes',
                 'string',
                 'nullable',
                 'email',
                 'max:255',
                 Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED);
                }),
            ],
            'phone' => [
                'sometimes',
                'string',
                'max:13',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::REGISTERED);
                }),
            ],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    protected function userRegistrationForms(User $user): array
    {
        return [
            'name' => $user->profile->full_name,
            'email' => $user->email,
            'username' => $user->profile->wp_username,
            'nickname' => $user->profile->wp_nickname,
            'password' => $user->profile->wp_password,
            'roles' => [
                'contributor',
            ],
        ];
    }
}
