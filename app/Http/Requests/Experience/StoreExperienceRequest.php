<?php

namespace App\Http\Requests\Experience;

use Illuminate\Foundation\Http\FormRequest;

class StoreExperienceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        
        return [
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_current' => 'nullable',
            'description' => 'nullable|string',
            'responsibilities' => 'nullable|string',
            'achievements' => 'nullable|string',
            'employment_type' => 'nullable|string|max:255',
            'industry' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png',
        ];
    }
}
