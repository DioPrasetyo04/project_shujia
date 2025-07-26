<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

interface HomeServiceInterface
{
    public function getAllDataWithCategory(): AnonymousResourceCollection | Collection;

    public function showDataHomeService($homeService): JsonResource;
}
