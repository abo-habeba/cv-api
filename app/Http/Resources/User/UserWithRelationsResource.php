<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use App\Http\Resources\User\UserResource;
use App\Http\Resources\Skills\SkillResource;
use App\Http\Resources\Socials\SocialResource;
use App\Http\Resources\Contact\ContactResource;
use App\Http\Resources\Projects\ProjectResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Language\LanguageResource;
use App\Http\Resources\Academics\AcademicResource;
use App\Http\Resources\Credential\CredentialResource;
use App\Http\Resources\Experience\ExperienceResource;

class UserWithRelationsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'user' => new UserResource($this),
            'experiences' => ExperienceResource::collection($this->whenLoaded('experiences')),
            'academics' => AcademicResource::collection($this->whenLoaded('academics')),
            'contacts' => ContactResource::collection($this->whenLoaded('contacts')),
            'credentials' => CredentialResource::collection($this->whenLoaded('credentials')),
            'languages' => LanguageResource::collection($this->whenLoaded('languages')),
            'projects' => ProjectResource::collection($this->whenLoaded('projects')),
            'skills' => SkillResource::collection($this->whenLoaded('skills')),
            'socials' => SocialResource::collection($this->whenLoaded('socials')),
        ];
    }
}
