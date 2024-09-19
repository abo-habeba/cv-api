<?php

namespace App\Http\Resources\Skills;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SkillResource extends JsonResource
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
            'description' => $this->translation($this->description),
            'level' => $this->level ?? null,
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d') : null,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
