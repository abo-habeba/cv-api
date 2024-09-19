<?php

namespace App\Http\Resources\Academics;

use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AcademicResource extends JsonResource
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
            'institution' => $this->translation($this->institution),
            'degree' => $this->translation($this->degree),
            'grade' => $this->translation($this->grade),
            'field_of_study' => $this->translation($this->field_of_study),
            'description' => $this->translation($this->description),
            'start_date' => isset($this->start_date) ? $this->start_date : null,
            'end_date' => isset($this->end_date) ? $this->end_date : null,
            'created_at' => isset($this->created_at) ? $this->created_at->format('Y-m-d') : null,
            'updated_at' => isset($this->updated_at) ? $this->updated_at->format('Y-m-d') : null,
            'photos' => PhotoResource::collection($this->whenLoaded('photos')),
        ];
    }
}
