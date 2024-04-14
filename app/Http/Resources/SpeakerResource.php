<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpeakerResource extends JsonResource
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
            'name' => $this->name,
            'surname' => $this->surname,
            'title' => $this->title,
            'company' => $this->company,
            'image_url' => $this->image_url,
            'resume' => $this->resume,
            'social_media' => $this->social_media,
            'full_details' => $this->getFullDetails(),
        ];
    }

    /**
     * Get full details of the speaker.
     *
     * This is an example of adding custom methods to your resource.
     */
    protected function getFullDetails(): string
    {
        return "{$this->name} {$this->surname}, {$this->title} at {$this->company}";
    }
}
