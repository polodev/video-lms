<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Chapter extends Model
{
    use HasSlug;

    protected $fillable = ['series_id', 'title', 'slug', 'folder_path', 'sort_order'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function series(): BelongsTo
    {
        return $this->belongsTo(Series::class);
    }

    public function videos(): HasMany
    {
        return $this->hasMany(Video::class)->orderBy('sort_order');
    }
}
