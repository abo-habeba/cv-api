<?php

namespace App\Http\Resources\Projects;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
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
            'title' => $this->translation($this->title),
            'description' => $this->translation($this->description),
            'url' => $this->url,
            'user_id' => $this->user_id,
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d') : null,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
