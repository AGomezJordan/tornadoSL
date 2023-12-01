<?php

namespace App\Http\Resources;

use App\Http\Resources\Chapter as ChapterResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Book extends JsonResource
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
            'title' => $this->title,
            'author' => $this->author,
            'published_at' => (new Carbon($this->published_at))->format('Y/m/d'),
            'chapters' => ChapterResource::collection($this->whenLoaded('chapters')),
        ];
    }
}
