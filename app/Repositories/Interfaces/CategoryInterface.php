<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface CategoryInterface
{
    public function getAllDataCategory(): Collection | AnonymousResourceCollection;

    public function showDataCategory($category): JsonResource;
}
