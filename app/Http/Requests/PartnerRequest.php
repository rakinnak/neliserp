<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PartnerRequest extends FormRequest
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
            'subject' => 'required',
            'code' => [
                'required',
                Rule::unique('partners')
                    ->ignore($this->partner ? $this->partner->id : null),
            ]
        ];
        
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $input = request()->all();

            switch (request()->get('subject')) {
                case 'company':
                    if (! request()->get('name')) {
                        $validator->errors()->add("name", "The name field is required.");
                    }
                    break;

                case 'person':
                    if (! request()->get('first_name')) {
                        $validator->errors()->add("first_name", "The first name field is required.");
                    }

                    if (! request()->get('last_name')) {
                        $validator->errors()->add("last_name", "The last name field is required.");
                    }
                    break;
            }
        });
    }
}
