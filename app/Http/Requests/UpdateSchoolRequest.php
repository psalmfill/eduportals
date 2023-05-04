<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSchoolRequest extends FormRequest
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
        $id = $urlArray[count($urlArray) - 1];
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
            'category' => 'required|exists:school_categories,id',
            'vendor' => 'required|exists:vendors,id',
            'address' => 'required',
            'country' => 'required|string',
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
