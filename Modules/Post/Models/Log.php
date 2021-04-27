<?php

namespace Modules\Post\Models;

use Modules\Auth\Models\User;
use Modules\Post\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Log extends Model
{
    use SoftDeletes;

    const DRAFTED = 1;
    const WAITED = 2;
    const PUBLISHED = 3;
    const DELETE = 98;
    const REJECTED = 99;

    protected $table = 'post_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'status',
        'meta',
        'message',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    protected $casts = [
        'meta' => 'array',
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

    /**
     * Get message owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
