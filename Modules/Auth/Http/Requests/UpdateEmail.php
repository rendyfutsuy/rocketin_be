<?php

namespace Modules\Auth\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Auth\Models\ResetEmail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmail extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => [
                'required_if:set_email,true',
                'nullable', 'email', 'max:255', 'unique:users,email',
                // Rule::unique('users')->ignore(auth()->user()->id),
            ],
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'email.required_if' => 'Email harus diisi.',
            'email.unique' => 'Email harus yang belum terdaftar.',
            'email.email' => 'Format email yang Anda masukkan salah',
        ];
    }

    /**
     * @return array
     */
    public function validated()
    {
        $results = parent::validated();

        return array_filter($results);
    }

    /**
     * @return array
     */
    public function getResetEmail()
    {
        return [
            'email' => $this->email,
            'expires_at' => Carbon::now()->addHours(ResetEmail::EXPIRED_TIME),
            'token' => Str::random(60),
            'activation_code' => generate_activation_code(6),
        ];
    }
}
