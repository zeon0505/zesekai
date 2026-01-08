<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'plan_name',
        'price',
        'status',
        'starts_at',
        'ends_at',
        'payment_method',
        'reference_id',
    ];

    protected function casts(): array
    {
        return [
            'starts_at' => 'datetime',
            'ends_at' => 'datetime',
            'price' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
