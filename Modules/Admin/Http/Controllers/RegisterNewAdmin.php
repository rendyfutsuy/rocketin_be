<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Modules\Auth\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Controllers\Auth\CustomAuth\CustomRegistration;

class RegisterNewAdmin extends CustomRegistration
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
        $this->validator($request->all())->validate();

        $this->create($request->all());

        return $this->responseMessage(
            self::SUCCESS,
            $this->translate('admin::registration.success', $this->getLocale($request)),
            200
        );
    }

    protected function create(array $data)
    {       
        return User::create($this->registerApplicant($data));
    }

    protected function registerApplicant(array $data): array
    {
        return [
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'level' => User::EDITOR,
            'activation_code' => null,
            'banned_at' => null,
            'email_verified_at' => now(),
            'phone' => Arr::get($data, 'phone') ?? null,
            'meta' => [
                'full_name' => Arr::get($data, 'name') ??  null,
            ],
        ];
    }

    protected function myRules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:128',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::ADMIN)
                        ->where('activation_code', null);
                }),
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->where(function ($query) {
                    return $query->where('level', User::ADMIN)
                        ->where('activation_code', null);
                }),
            ],
            'password' => ['required', 'string', 'min:6'],
        ];
    }
}
