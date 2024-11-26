<?php

namespace App\Http\Requests\Admin\Complaints;

use Illuminate\Foundation\Http\FormRequest;

class StoreClosureDetailsRequest extends FormRequest
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
            'no_of_male_injured' => 'nullable',
            'no_of_female_injured' => 'nullable',
            'no_of_child_injured' => 'nullable',
            'total_injured' => 'nullable',
            'no_of_male_death' => 'nullable',
            'no_of_female_death' => 'nullable',
            'no_of_child_death' => 'nullable',
            'total_death' => 'nullable',
            'remark' => 'required',
            'upload_doc' => 'nullable',
            'loss_type' => 'required',
            'description' => 'nullable',
        ];
    }
}
