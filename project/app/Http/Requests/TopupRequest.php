<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopupRequest extends FormRequest
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
            'amount' => 'required|numeric|min:1'
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Invalid amount',
            'amount.numeric' => 'Invalid amount',
            'amount.min' => 'Amount should be at least 1'

        ];
    }
}
