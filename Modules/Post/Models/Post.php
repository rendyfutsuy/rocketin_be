<?php

namespace Modules\Post\Models;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Modules\Auth\Models\User;
use Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    use SoftDeletes;

    const DRAFTED = 'draft';
    const PUBLISHED = 'publish';
    const WAITED = 'wait';
    const FUTURE = 'future';
    const PENDING = 'pending';
    const PERSONAL = 'private';
    const DELETE = 'delete';
    const REJECTED = 'rejected';

    protected $table = 'posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wp_post_id',
        'title',
        'slug',
        'content',
        'raw_content',
        'author',
        'excerpt',
        'comment_status',
        'format',
        'template',
        'meta',
        'categories',
        'tags',
        'status',
        'featured_media',
        'published_at',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    protected $casts = [
        'meta' => 'array',
        'categories' => 'array',
        'tags' => 'array',
        'raw_content' => 'array',
        'published_at' => 'datetime',
    ];

    /**
     * Get message owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isPublished(): bool
    {
        return $this->status == self::PUBLISHED;
    }

    public function isRejected(): bool
    {
        return $this->status == self::REJECTED;
    }

    public function canNotPublish(): bool
    {
        return word_counter($this->content) < config('post.min_content', 10) ||
            $this->title == null || 
            word_counter($this->title) > config('post.max_title', 50) ||
            empty($this->featured_media) ||
            count($this->gallery) < config('post.min_gallery_images', 3);
    }

    public function getExcerptAttribute($value)
    {
        if (! $value) {
            if (Str::length($this->raw_description) < 100) {
                return $this->raw_description;
            }

            return Str::substr($this->raw_description, 0, 105) . '...';
        }

        return $value;
    }

    public function getWpUrl(): ?string
    {
        if (empty($this->wp_post_id)) {
            return null;
        }

        return config('post.wp_base_url') . '?p='. $this->wp_post_id;
    }

    public function getFeaturedUrlAttribute(): ?string
    {
        if ($this->featuredImage) {
            return optional($this->featuredImage)->source_url;
        }

        if (empty($this->raw_content)) {
            return null;
        }

        return Arr::get($this->raw_content, 'featured_url');
    }

    public function getGalleryAttribute(): array
    {
        if (empty($this->raw_content)) {
            return [];
        }

        return $this->raw_content['images'];
    }

    public function getCaptionAttribute(): array
    {
        if (empty($this->raw_content)) {
            return [];
        }

        if (! Arr::exists($this->raw_content, 'captions')) {
            return [];
        }

        return $this->raw_content['captions'];
    }

    public function getLocationAttribute(): ?string
    {
        if (empty($this->raw_content)) {
            return null;
        }

        if (! Arr::exists($this->raw_content, 'location')) {
            return null;
        }

        return $this->raw_content['location'];
    }

    public function getRejectedNoteAttribute(): ?string
    {
        if (empty($this->meta)) {
            return __('post::reject.default', [], auth()->user()->getLocale());
        }

        if (! Arr::exists($this->meta, 'rejected_note')) {
            return __('post::reject.default', [], auth()->user()->getLocale());
        }

        return $this->meta['rejected_note'];
    }

    public function getRawDescriptionAttribute(): ?string
    {
        if (empty($this->raw_content)) {
            return null;
        }

        return $this->raw_content['description'];
    }

    public function getRawContactAttribute(): ?array
    {
        if (empty($this->raw_content)) {
            return [];
        }

        if (! Arr::exists($this->raw_content, 'contacts')) {
            return [];
        }

        return $this->raw_content['contacts'];
    }

    /**
     * Post can has many media.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medias()
    {
        return $this->belongsToMany(
            Media::class,
            'media_post',
            'post_id',
            'media_id'
        );
    }

    /**
     * Post can has many media.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function featuredImage()
    {
        return $this->hasOne(
            Media::class,
            'wp_media_id',
            'featured_media',
        );
    }
    
    public function scopeToday(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->format('Y-m-d 00:00:00'),
            Carbon::now()->format('Y-m-d 23:59:59'),
        ]);
    }

    public function scopeWeek(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->startOfWeek()->format('Y-m-d 00:00:00'),
            Carbon::now()->endOfWeek()->format('Y-m-d 23:59:59'),
        ]);
    }

    public function scopeMonth(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->startOfMonth()->format('Y-m-d 00:00:00'),
            Carbon::now()->endOfMonth()->format('Y-m-d 23:59:59'),
        ]);
    }

    public function scopeYear(Builder $logs): Builder
    {
        return $logs->whereBetween('created_at', [
            Carbon::now()->startOfYear()->format('Y-m-d 00:00:00'),
            Carbon::now()->endOfYear()->format('Y-m-d 23:59:59'),
        ]);
    }
}
