<?php

namespace App\Http\Requests\Socials;

use Illuminate\Foundation\Http\FormRequest;

class DeleteSocialRequest extends FormRequest
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
