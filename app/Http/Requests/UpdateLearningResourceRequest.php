<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLearningResourceRequest extends FormRequest
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
            "school_class_id" => 'required|exists:school_classes,id',
            "subject_id" => 'required|exists:subjects,id',
            "title" => 'required',
            "description" => 'required',
            "type" => "required",
            "file" => "nullable",
            "content" => "nullable"
        ];
    }
}
