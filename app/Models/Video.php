<?php

namespace App\Models;

use App\Models\User;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'duration',
        'artist',
        'genre',
        'watchUrl',
        'user_id',
        'views',
        'vote',
        'like',
    ];

    /**
     * Get the user that owns the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The views that belong to the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function views(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'views', 'video_id', 'user_id');
    }

    /**
     * The genres that belong to the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class, 'genre_video', 'video_id', 'genre_id');
    }

    /**
     * The artists that belong to the Video
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function artists(): BelongsToMany
    {
        return $this->belongsToMany(Artist::class, 'artist_video', 'video_id', 'artist_id');
    }
}
