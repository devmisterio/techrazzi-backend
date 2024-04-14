<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventDetailResource extends JsonResource
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
            'abstract' => $this->abstract,
            'list_image' => $this->list_image,
            'banner_image' => $this->banner_image,
            'start_time' => Carbon::parse($this->start_date)->format('H:i'),
            'start_date' => Carbon::parse($this->start_date)->translatedFormat('d F y'),
            'is_online' => $this->is_online,
            'venue' => new VenueResource($this->venue),
            'comments' => CommentResource::collection($this->comments),
            'participants' => UserResource::collection($this->participants),
            'talks' => TalkResource::collection($this->talks),
        ];
    }
}
