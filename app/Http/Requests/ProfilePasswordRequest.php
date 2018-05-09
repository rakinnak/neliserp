<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Hash;

class ProfilePasswordRequest extends FormRequest
{
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $input = request()->all();

            $user = auth()->user();

            if (request()->has('old_password')) {
                if (! Hash::check($input['old_password'], $user->password)) {
                    $validator->errors()->add("old_password", "The old password is invalid.");
                }
            }
        });
    }
}
