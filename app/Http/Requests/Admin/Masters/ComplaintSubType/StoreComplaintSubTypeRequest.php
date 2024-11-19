<?php

namespace App\Http\Requests\Admin\Masters\ComplaintSubType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreComplaintSubTypeRequest extends FormRequest
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
            'complaint_sub_type_name' => [
                'required',
                Rule::unique('complaint_sub_types', 'complaint_sub_type_name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'initial' => 'required',
            'complaint_type' => 'required',
        ];
    }
}
