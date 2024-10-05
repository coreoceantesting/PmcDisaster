<?php

namespace App\Http\Requests\Admin\Complaints;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'complaint_type' => 'required',
            'complaint_sub_type' => 'required',
            'manual_complaint_no' => 'nullable',
            'caller_name' => 'required',
            'caller_mobile_no' => 'required|digits:10',
            'caller_address' => 'required',
            'complaint_details' => 'required',
            'location' => 'required',
            'departments' => 'required',
            'uploaded_doc' => 'nullable',
        ];
    }
}
