<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentFormRequest extends FormRequest
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
            'first_name' => 'required|string|min:3',
            'last_name' => 'required|string|min:3',
            'other_name' => 'string|nullable',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date',
            'blood_group' => 'required|in:A+,A-,B+,B-,O+,O-,AB+,AB-',
            'genotype'  => 'required|in:AA,AS,AC,SS',
            'country' =>  'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'passport' => 'nullable|mimes:jpeg,jpg,png|max:200',
            'address_1' => 'required|string',
            'class' => 'required|exists:school_classes,id',
            'section' => 'required|exists:sections,id',
            // 'reg_no'  => 'required|string',
            'parent.first_name' => 'required|string|min:3',
            'parent.last_name' => 'required|string|min:3',
            'parent.other_name' => 'string|nullable',
            'parent.phone_number' => 'required|numeric',
            'parent.address' => 'required',
            'parent.email' => 'required'

        ];
    }
}
