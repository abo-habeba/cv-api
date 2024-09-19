<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'username' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255',
            'password' => 'sometimes|string|min:8',
            'phone' => 'sometimes|nullable',
            'address' => 'sometimes|string|max:255',
            'role' => 'sometimes|string',
            'theme' => 'sometimes|string',
            'bio_ar' => 'sometimes|nullable|string',
            'bio_en' => 'sometimes|nullable|string',
            'about_ar' => 'sometimes|nullable|string',
            'about_en' => 'sometimes|nullable|string',
            'position' => 'sometimes|string|max:255',
            'profile_image' => 'sometimes',
            'hero' => 'sometimes|nullable',
        ];
    }
}
