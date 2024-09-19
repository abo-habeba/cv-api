<?php

namespace App\Http\Requests\Credential;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCredentialRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'sometimes|string|max:255',
            'issuer' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'issue_date' => 'sometimes|date',
            'expiry_date' => 'sometimes|nullable|date|after_or_equal:issue_date',
            'credential_id' => 'sometimes|nullable|string|max:255',
            'user_id' => 'sometimes|exists:users,id',
            'photos.*' => 'sometimes|nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
    
}
