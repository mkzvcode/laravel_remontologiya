<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewCase extends Model
{
    protected $fillable = ['code', 'title', 'text_body', 'image', 'image_alt', 'budget', 'note', 'sort_order'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
