<?php

namespace App\Http\Resources\Credential;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CredentialResource extends JsonResource
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
            'issuer' => $this->translation($this->issuer),
            'description' => $this->translation($this->description),
            'credential_id' => $this->credential_id,
            'user_id' => $this->user_id,
            'issue_date' => $this->issue_date ? (new \DateTime($this->issue_date))->format('Y-m-d') : null,
            'expiry_date' => $this->expiry_date ? (new \DateTime($this->expiry_date))->format('Y-m-d') : null,
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d') : null,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
