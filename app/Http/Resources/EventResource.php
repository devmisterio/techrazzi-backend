<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'description' => $this->description,
            'list_image' => $this->list_image,
            'start_date' => Carbon::parse($this->start_date)->translatedFormat('d F y'),
            'venue' => [
                'id' => $this->venue_id,
                'city' => $this->city,
            ],
            'is_online' => (bool) $this->is_online,
            'is_participant_limit_reached' => (bool) $this->is_participant_limit_reached
        ];
    }
}
