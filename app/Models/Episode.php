<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $fillable = [
        'anime_id', 'title', 'episode_number', 'video_url', 'thumbnail_image', 'released_at'
    ];

    protected $casts = [
        'released_at' => 'date',
        'episode_number' => 'integer',
    ];

    public function anime()
    {
        return $this->belongsTo(Anime::class);
    }
}
