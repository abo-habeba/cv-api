<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLanguageRequest extends FormRequest
{
    
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|required|string|max:255',
            'level' => 'sometimes|required|string|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
        ];
    }
}
