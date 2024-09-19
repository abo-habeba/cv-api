<?php

namespace App\Http\Requests\Credential;

use Illuminate\Foundation\Http\FormRequest;

class StoreCredentialRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'description' => 'nullable|string',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after_or_equal:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'user_id' => 'required|exists:users,id',
            'photos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}