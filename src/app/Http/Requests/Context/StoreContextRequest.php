<?php

namespace App\Http\Requests\Context;

use Illuminate\Foundation\Http\FormRequest;

class StoreContextRequest extends FormRequest
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
            'name' => 'required|string|max:150',
            'parent_context_id' => "numeric|integer",
            'order' => "numeric|integer|nullable",
            'tags' => 'nullable|array'
        ];
    }
}
