<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promise extends Model
{
    protected $fillable = ['number', 'title', 'text', 'is_dark', 'sort_order'];

    protected $casts = ['is_dark' => 'boolean'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
