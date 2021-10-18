<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HistorySearchRequest extends FormRequest
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
            'dateFrom' => 'required|date',
            'dateTo' => 'required|date|after_or_equal:dateFrom'
        ];
    }

    public function messages()
    {
        return [
            'dateFrom.required' => 'Start date is required.',
            'dateTo.required' => 'End date is required.',
            'dateTo.after_or_equal' => 'End date should be after or equal Start date.'

        ];
    }
}
