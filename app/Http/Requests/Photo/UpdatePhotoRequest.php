<?php

namespace App\Http\Requests\Photo;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePhotoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'path' => 'sometimes|required|string|max:255',
            'type' => 'nullable|string|max:255',
            'imageable_type' => 'sometimes|required|string|max:255',
            'imageable_id' => 'sometimes|required|integer|exists:your_related_table,id', // تأكد من تحديد اسم الجدول الصحيح
        ];
    }
}
