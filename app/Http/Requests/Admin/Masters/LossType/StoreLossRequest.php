<?php

namespace App\Http\Requests\Admin\Masters\LossType;

use Illuminate\Foundation\Http\FormRequest;

class StoreLossRequest extends FormRequest
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
            'loss_type_name' => 'required|unique:losses,loss_type_name',
            'initial' => 'nullable',
        ];
    }
}
