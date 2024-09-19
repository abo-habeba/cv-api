<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class StoreLanguageRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
