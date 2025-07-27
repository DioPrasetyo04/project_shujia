<?php

namespace App\Services;

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

    public function getAllDataWithCategory($request)
    {
        $homeServices = $this->homeService->getAllDataWithCategory();

        if ($request->has('category_id')) {
            $homeServices = $homeServices->where('category_id', $request->input('category_id'));
        }

        if ($request->has('is_popular')) {
            $homeServices = $homeServices->where('is_popular', $request->input('is_popular'));
        }

        if ($request->has('limit')) {
            $homeServices = $homeServices->limit($request->input('limit'));
        }

        return HomeServiceApiResource::collection($homeServices->get());
    }
}
