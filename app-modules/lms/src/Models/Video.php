<?php

namespace Modules\Lms\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Video extends Model
{
    use HasSlug;

    protected $fillable = [
        'chapter_id', 'extension', 'path_name', 'slug', 'file_name',
        'file_type', 'file_name_without_extension', 'sort_order', 'duration_seconds',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('file_name_without_extension')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }

    public function chapter(): BelongsTo
    {
        return $this->belongsTo(Chapter::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(VideoProgress::class);
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(Bookmark::class, 'bookmark_video');
    }

    public function isVideo(): bool
    {
        return $this->file_type === 'video';
    }

    public function isPdf(): bool
    {
        return $this->file_type === 'pdf';
    }
}
