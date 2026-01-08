<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WatchLog extends Model
{
    protected $fillable = ['user_id', 'ip_address', 'episode_id', 'last_time'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function episode()
    {
        return $this->belongsTo(Episode::class);
    }
}
