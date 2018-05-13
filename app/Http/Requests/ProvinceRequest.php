<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProvinceRequest extends FormRequest
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
            'code' => [
                'required',
                Rule::unique('provinces')
                    ->ignore($this->province ? $this->province->id : null),
            ],
            'name' => [
                'required',
                Rule::unique('provinces')
                    ->ignore($this->province ? $this->province->id : null),
            ],
        ];
        
    }
}
