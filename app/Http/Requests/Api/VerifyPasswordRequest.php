<?php

namespace App\Http\Requests\Api;

use App\Http\Traits\TJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class VerifyPasswordRequest extends FormRequest
{
    use TJsonResponse;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phone' => 'numeric|required|exists:sms_codes,phone',
            'code' => 'required|numeric|exists:sms_codes,code',
        ];
    }
}
