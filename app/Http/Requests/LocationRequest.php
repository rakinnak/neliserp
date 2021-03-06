<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LocationRequest extends FormRequest
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
                Rule::unique('locations')
                    ->ignore($this->location ? $this->location->id : null),
            ],
            'name' => [
                'required',
                Rule::unique('locations')
                    ->ignore($this->location ? $this->location->id : null),
            ],
            'parent_uuid' => 'nullable|exists:locations,uuid',
        ];
        
    }
}
