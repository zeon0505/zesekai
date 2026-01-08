<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    protected $fillable = ['name', 'slug'];

    public function animes()
    {
        return $this->hasMany(Anime::class);
    }
}
