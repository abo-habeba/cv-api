<?php

namespace App\Http\Requests\Skills;

use Illuminate\Foundation\Http\FormRequest;

class StoreSkillRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:skills,name',
            'description' => 'nullable|string',
            'level' => 'nullable|string|max:255',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
