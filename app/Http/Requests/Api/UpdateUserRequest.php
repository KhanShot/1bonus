<?php

namespace App\Http\Requests\Api;

use App\Http\Traits\TJsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'string|required',
            'surname' => 'string|required',
            'birthday' => 'date|required',
            'gender' => 'required',
            'family_status' => 'required',
            'city' => 'required|exists:cities,id',
            'email' => 'email|unique:users,email,'. $this->user()->id,
        ];
    }
}
