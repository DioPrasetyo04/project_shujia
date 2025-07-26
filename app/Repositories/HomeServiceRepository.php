<?php

namespace App\Repositories;

use App\Models\HomeService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Api\HomeServiceApiResource;
use App\Repositories\Interfaces\HomeServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HomeServiceRepository implements HomeServiceInterface
{
    public function getAllDataWithCategory(): Collection | AnonymousResourceCollection
    {
        return HomeService::with('category')->get();
    }

    public function showDataHomeService($homeService): JsonResource
    {
        // akan mencari data home service berdasarkan slug dan lengkap dengan relasinya ke category, benefits, dan testimonials
        $homeService->load(['category', 'benefits', 'testimonials']);
        return new HomeServiceApiResource($homeService);
    }
}
