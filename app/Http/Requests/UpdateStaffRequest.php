<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'other_name' => 'nullable|string',
            'gender' => 'nullable|string',
            'date_of_birth' => 'required',
            'email' => 'required',
            'address_1' => 'required',
            'address_2' => 'nullable',
            'image' => 'nullable',
            'phone_number' => 'nullable',
            'country' => 'nullable',
            'state' => 'required',
            'city' => 'required',
            'religion' => 'nullable',
        ];
    }
}
