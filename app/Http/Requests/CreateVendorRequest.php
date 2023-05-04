<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateVendorRequest extends FormRequest
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
            'code' => 'required|string|unique:vendors',
            'email' => 'required|email|unique:vendors',
            'address' => 'required',
            'country' => 'required|string',
            'state' => 'required|string',
            'category' => 'required|exists:vendor_categories,id',
            'city' => 'required|string',
            'admin_first_name' => 'required|string',
            'admin_last_name' => 'required|string',
            'admin_other_name' => 'nullable|string',
            'admin_address' => 'required|string',
            'admin_email' => 'required|email|unique:users,email',
            'admin_phone_number' => 'required|string',
        ];
    }
}
