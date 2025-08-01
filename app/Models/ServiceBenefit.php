<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceBenefit extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'home_service_id',
    ];

    public function homeServices()
    {
        return $this->belongsTo(HomeService::class);
    }
}
