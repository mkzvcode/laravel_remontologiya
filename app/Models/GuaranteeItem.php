<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuaranteeItem extends Model
{
    protected $fillable = ['type', 'text', 'sort_order'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }
}
