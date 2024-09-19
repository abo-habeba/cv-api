<?php

namespace App\Http\Requests\Skills;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'level' => 'sometimes|nullable|string|max:255',
            'photos.*' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
