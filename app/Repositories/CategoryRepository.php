<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\Api\CategoryApiResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryRepository implements CategoryInterface
{
    public function getAllDataCategory(): Collection | AnonymousResourceCollection
    {
        return Category::all();
    }

    public function showDataCategory($category): JsonResource
    {
        $category->load(['homeServices']);

        return new CategoryApiResource($category);
    }
}
