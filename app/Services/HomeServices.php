<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Resources\Api\HomeServiceApiResource;
use App\Repositories\Interfaces\HomeServiceInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class HomeServices
{
    protected $homeService;
    public function __construct(
        HomeServiceInterface $homeServiceInterface
    ) {
        $this->homeService = $homeServiceInterface;
    }

    public function getAllDataWithCategory($request): Collection | AnonymousResourceCollection
    {
        $homeServices = $this->homeService->getAllDataWithCategory();

        if ($request->has('category_id')) {
            $homeServices = $this->homeService->getAllDataWithCategory()->where('category_id', $request->input('category_id'));
        }

        if ($request->has('is_popular')) {
            $homeServices = $this->homeService->getAllDataWithCategory()->where('is_popular', $request->input('is_popular'));
        }

        if ($request->has('limit')) {
            $homeServices = $this->homeService->getAllDataWithCategory()->limit($request->input('limit'));
        }

        return HomeServiceApiResource::collection($homeServices);
    }
}
