<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'photo',
        'photo_white',
    ];

    public function setNameAtrribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = trim($value) ? Str::slug($value) : Str::slug($value);
    }

    public function homeServices(): HasMany
    {
        return $this->hasMany(HomeService::class);
    }
}
