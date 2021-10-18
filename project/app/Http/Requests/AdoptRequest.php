<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdoptRequest extends FormRequest
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
            // rule form 1
            'name' => ['required', 'string' , 'between:3,20'],
            // rule form 2
            'agreement' => 'required|string',
            'category' => 'required|array',
            'images' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.between' => 'Name must be at least 3 characters and below 20',
            'agreement.required' => 'Agreement is required',
            'category.required' => 'Category is required',
            'images.required' => 'Images is required',
        ];
    }
}
