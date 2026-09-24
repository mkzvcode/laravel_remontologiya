<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriceItem extends Model
{
    protected $fillable = ['price_category_id', 'name', 'unit', 'price_text', 'sort_order'];

    public function category()
    {
        return $this->belongsTo(PriceCategory::class, 'price_category_id');
    }
}
