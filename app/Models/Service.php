<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'number', 'title', 'price_label', 'duration', 'description',
        'image', 'image_alt', 'is_featured_home', 'sort_order', 'is_published',
    ];

    protected $casts = [
        'is_featured_home' => 'boolean',
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
