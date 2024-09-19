<?php

namespace App\Http\Requests\Language;

use Illuminate\Foundation\Http\FormRequest;

class DeleteLanguageRequest extends FormRequest
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
            'id' => 'required',
        ];
    }
}
