<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InstitutionStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "name" => 'required',
            'description' => 'string',
            'image' => 'required|image',
//            'logo' => 'required|image',
            'phone' => "required",
            'full_address' => 'required',
            'lat' => 'required',
            'city' => 'required',
            'category' => 'required',
            'long' => 'required',
            'premiseNumber' => 'required',
            'street' => 'required',
            'city_id' => 'required'
        ];
    }
}
