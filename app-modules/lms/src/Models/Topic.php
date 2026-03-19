<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Topic extends Model
{
    use HasSlug;

    protected $fillable = ['title', 'slug'];

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

    public function series(): BelongsToMany
    {
        return $this->belongsToMany(Series::class, 'series_topic');
    }
}
