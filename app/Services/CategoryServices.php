<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\Api\CategoryApiResource;
use App\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryServices
{
    protected $categoryService;
    public function __construct(
        CategoryInterface $categoryInterface
    ) {
        $this->categoryService = $categoryInterface;
    }

    public function getAllDataCategory($request): Collection | AnonymousResourceCollection
    {
        if ($request->has('limit')) {
            return $this->categoryService->getAllDataCategory()->limit($request->input('limit'));
        }
        return CategoryApiResource::collection($this->categoryService->getAllDataCategory());
    }
}
