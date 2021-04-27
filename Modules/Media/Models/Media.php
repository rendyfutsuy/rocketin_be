<?php

namespace Modules\Media\Models;

use Modules\Auth\Models\User;
use Modules\Post\Models\Post;
use Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use SoftDeletes;

    protected $table = 'medias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wp_media_id',
        'source_url',
        'title',
        'description',
        'media_type',
        'caption',
        'alt_text',
        'meta',
        'media_detail',
        'is_featured',
    ];

    protected $casts = [
        'meta' => 'array',
        'media_detail' => 'array',
    ];


    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Get message owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Media can has many post.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(
            Post::class,
            'media_post',
            'media_id',
            'post_id'
        );
    }

}