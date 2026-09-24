<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuaranteeDoc extends Model
{
    protected $fillable = ['number', 'title', 'text_body', 'is_featured', 'sort_order'];

    protected $casts = ['is_featured' => 'boolean'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
