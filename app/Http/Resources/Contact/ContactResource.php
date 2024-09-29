<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->translation($this->name),
            'message' => $this->translation($this->message),
            'subject' => $this->translation($this->subject),
            'email' => $this->email,
            'phone' => $this->phone,
            'user_id' => $this->user_id,
            'read' => $this->read,
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d') : null,
        ];
    }
}
