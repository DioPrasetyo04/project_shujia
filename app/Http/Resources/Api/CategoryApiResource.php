<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryApiResource extends JsonResource
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
            'photo' => $this->photo,
            'photo_white' => $this->photo_white,
        ];
    }
}
