<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioCase extends Model
{
    protected $fillable = [
        'kind', 'code', 'title', 'tag_label', 'image', 'image_alt', 'image_before',
        'area', 'days', 'budget', 'delta', 'text_body', 'chips',
        'sort_order', 'is_published', 'show_on_home',
    ];

    protected $casts = [
        'chips' => 'array',
        'is_published' => 'boolean',
        'show_on_home' => 'boolean',
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
