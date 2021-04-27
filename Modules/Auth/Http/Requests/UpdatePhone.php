<?php

namespace Modules\Auth\Http\Requests;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Modules\Auth\Models\ResetPhone;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePhone extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => [
                'required_if:set_phone,true',
                'nullable', 'phone', 'max:15', 'unique:users,phone',
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
            'phone.required_if' => 'Phone harus diisi.',
            'phone.unique' => 'Phone harus yang belum terdaftar.',
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
    public function getResetPhone()
    {
        return [
            'phone' => $this->phone,
            'expires_at' => Carbon::now()->addHours(ResetPhone::EXPIRED_TIME),
            'token' => Str::random(60),
            'activation_code' => generate_activation_code(6),
        ];
    }
}
