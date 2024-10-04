<?php

namespace App\Http\Requests\Admin\Masters\ComplaintType;

use Illuminate\Foundation\Http\FormRequest;

class UpdateComplaintTypeRequest extends FormRequest
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
            'complaint_type_name' => 'required',
            'initial' => 'required',
        ];
    }
}