<?php

namespace App\Http\Requests\Admin\Masters\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDepartmentRequest extends FormRequest
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
            'department_name' => [
                'required',
                Rule::unique('departments', 'department_name')->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            ],
            'initial' => 'required',
        ];
    }
}
