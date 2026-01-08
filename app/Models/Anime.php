<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anime extends Model
{
    protected $fillable = [
        'title', 'slug', 'synopsis', 'poster_image', 'banner_image', 
        'type', 'status', 'aired_at', 'studio_id', 'is_premium'
    ];

    protected $casts = [
        'is_premium' => 'boolean',
        'aired_at' => 'date',
    ];

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
