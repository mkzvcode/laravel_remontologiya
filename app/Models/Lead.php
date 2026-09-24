<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['source', 'name', 'phone', 'area', 'message', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    public function scopeNewest($query)
    {
        return $query->orderByDesc('created_at');
    }
}
