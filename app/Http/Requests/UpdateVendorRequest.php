<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVendorRequest extends FormRequest
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
        $urlArray = explode('/', url()->current());
        $id = $urlArray[count($urlArray)-1];
        return [
            'name' => 'required|string',
            'code' => [
                'required', 'string',
                Rule::unique('vendors')->ignore($id)
            ],
            'email' => [
                'required', 'email',
                Rule::unique('vendors')->ignore($id)
            ],
            'address' => 'required',
            'country' => 'required|string',
            'category' => 'required|exists:vendor_categories,id',
            'state' => 'required|string',
            'city' => 'required|string',
            'admin_first_name' => 'required|string',
            'admin_last_name' => 'required|string',
            'admin_other_name' => 'nullable|string',
            'admin_address' => 'required|string',
            'admin_email' => 'required|email',
            'admin_phone_number' => 'required|string',
        ];
    }
}
