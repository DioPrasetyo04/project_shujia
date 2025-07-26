<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class HomeService extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'thumbnail',
        'about',
        'duration',
        'price',
        'is_popular',
        'category_id',
    ];

    // mutator function untuk setter name atribute untuk generate slug
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = trim($value) ? Str::slug($value) : Str::slug($value);
    }

    public function benefits(): HasMany
    {
        return $this->hasMany(ServiceBenefit::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(ServiceTestimonial::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function transactionDetails(): HasMany
    {
        return $this->hasMany(TransactionDetails::class);
    }
}
