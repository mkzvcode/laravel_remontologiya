<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = [
        'name', 'description', 'price_from', 'price_unit',
        'is_featured', 'badge_text', 'bg_variant', 'items', 'cta_label', 'sort_order',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'items' => 'array',
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
