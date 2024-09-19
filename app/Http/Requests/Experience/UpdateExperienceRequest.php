<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
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
            'title' => 'sometimes|required|string|max:255',
            'company' => 'sometimes|required|string|max:255',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
            'is_current' => 'sometimes|nullable',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'achievements' => 'nullable|string',
            'employment_type' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
