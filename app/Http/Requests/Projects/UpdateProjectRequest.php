<?php

namespace App\Http\Requests\Projects;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'url' => 'nullable|url|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
            'photos.*' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
