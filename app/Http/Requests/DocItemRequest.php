<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DocItemRequest extends FormRequest
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
            'line_number' => 'required|numeric|min:0',
            'item_code' => 'required|exists:items,code',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
        ];
        
    }
}
