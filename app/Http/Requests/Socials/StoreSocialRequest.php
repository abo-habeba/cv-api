<?php

namespace App\Http\Requests\Socials;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
