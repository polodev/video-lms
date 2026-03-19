<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Series extends Model
{
    use HasSlug;

    protected $fillable = ['title', 'slug', 'url', 'description', 'hidden'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class)->orderBy('sort_order');
    }

    public function topics(): BelongsToMany
    {
        return $this->belongsToMany(Topic::class, 'series_topic');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function scopeVisible($query)
    {
        return $query->where('hidden', false);
    }

    public function scopeHidden($query)
    {
        return $query->where('hidden', true);
    }
}
