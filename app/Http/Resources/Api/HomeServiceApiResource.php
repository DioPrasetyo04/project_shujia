<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HomeServiceApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    // nampilin semua data yang ada di category
    // public function toArray(Request $request): array
    // {
    //     return parent::toArray($request);
    // }

    // custom tampilan data category
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'about' => $this->about,
            'duration' => $this->duration,
            'price' => $this->price,
            'is_popular' => $this->is_popular,
            'category_id' => $this->category_id,
            // ketika category di load atau dipanggil, maka akan memanggil fungsi di CategoryApiResource
            'category' => $this->whenLoaded('category', new CategoryApiResource($this->category)),
        ];
    }
}
