<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'name', 'meta', 'text_body', 'avatar_letter',
        'is_dark', 'show_on_home', 'sort_order', 'is_published',
    ];

    protected $casts = [
        'is_dark' => 'boolean',
        'show_on_home' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
