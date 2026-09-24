<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicePerk extends Model
{
    protected $fillable = ['title', 'text', 'sort_order'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
