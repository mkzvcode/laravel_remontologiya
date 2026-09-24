<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceCategory extends Model
{
    protected $fillable = ['number', 'title', 'subtitle', 'sort_order'];

    public function items()
    {
        return $this->hasMany(PriceItem::class)->orderBy('sort_order');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
