<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'title'         => $this->title,
            'slug'          => $this->slug,
            'summary'       => $this->summary,
            'content'       => $this->content,
            'image_url'     => $this->image_url,
            'is_published'  => $this->is_published,
            'published_at'  => $this->published_at?->toIso8601String(),
        ];
    }
}
