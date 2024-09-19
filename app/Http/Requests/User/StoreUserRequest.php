<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'profile_image' => 'nullable|string|max:255',
            'role' => 'sometimes|string',
            'theme' => 'sometimes|string',
            'bio_ar' => 'nullable|string',
            'bio_en' => 'nullable|string',
            'about_ar' => 'nullable|string',
            'about_en' => 'nullable|string',
            'position' => 'nullable|string|max:255',
            'hero' => 'nullable',
        ];
    }
}
