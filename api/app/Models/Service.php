<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Service extends Model
{
    use HasFactory, HasSlug;

    protected $guarded = [];

    public function employees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'employee_services', 'service_id', 'employee_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getPriceAttribute($value): string
    {
        return '$' . number_format($value / 100, 2);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }
}
