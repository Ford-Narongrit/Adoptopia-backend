<?php

namespace App\Http\Requests;

use App\Rules\WithdrawRule;
use Illuminate\Foundation\Http\FormRequest;
use Tymon\JWTAuth\Facades\JWTAuth;

class WithdrawRequest extends FormRequest
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
            'amount' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value <= 0) {
                        $fail('Amount should be at least 1');
                    }
                },
                function ($attribute, $value, $fail) {
                    $user = JWTAuth::user();
                    if ($value > $user->coin) {
                        $fail("You don't have enough coin.");
                    }
                }

            ]
        ];
    }

    public function messages()
    {
        return [
            'amount.required' => 'Invalid amount',

        ];
    }
}
