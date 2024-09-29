<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'first_name' => $this->translation($this->first_name),
            'last_name' => $this->translation($this->last_name),
            'address' => $this->translation($this->address),
            'bio_ar' => $this->bio_ar,
            'bio_en' => $this->bio_en,
            'about_ar' => $this->about_ar,
            'about_en' => $this->about_en,
            'position' => $this->translation($this->position),
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'profile_image' => $this->profile_image ? asset($this->profile_image) : null,
            'unread_contacts_count' => $this->contacts()->where('read', 0)->count(),
            'hero' => $this->photos->filter(function ($photo) {
                return $photo->type === 'hero';
            })->map(function ($photo) {
                return new PhotoResource($photo);
            }),
            'role' => json_decode($this->role),
            'theme' => $this->theme ? json_decode($this->theme) : new \stdClass(),
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at->format('Y-m-d H:i:s') : null,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:i:s') : null,
        ];
    }
}
