<?php

namespace App\Http\Resources\Experience;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
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
            'company' => $this->translation($this->company),
            'description' => $this->translation($this->description),
            'responsibilities' => $this->translation($this->responsibilities),
            'achievements' => $this->translation($this->achievements),
            'employment_type' => $this->translation($this->employment_type),
            'industry' => $this->translation($this->industry),
            'location' => $this->translation($this->location),
            'start_date' => $this->start_date ? (new \DateTime($this->start_date))->format('Y-m-d') : null,
            'end_date' => $this->is_current ? (object) ['ar' => '1', 'en' => '1'] : ['ar' => (new \DateTime($this->end_date))->format('Y-m-d'), 'en' => (new \DateTime($this->end_date))->format('Y-m-d')],
            'image' => $this->image ? $this->image : null,
            'user_id' => $this->user_id,
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d') : null,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
