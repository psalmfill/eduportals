<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSchoolRequest extends FormRequest
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
            'name' => 'required|string',
            'code' => 'required|string|unique:schools',
            'email' => 'required|email|unique:schools',
            'address' => 'required',
            'country' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'category' => 'required|exists:school_categories,id',
            'vendor' => 'required|exists:vendors,id',
            'admin_first_name' => 'required|string',
            'admin_last_name' => 'required|string',
            'admin_other_name' => 'nullable|string',
            'admin_address' => 'required|string',
            'admin_email' => 'required|email',
            'admin_phone_number' => 'required|string',
        ];
    }
}
