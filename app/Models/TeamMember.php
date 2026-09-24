<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = ['name', 'role', 'avatar_letter', 'note', 'show_on_home', 'sort_order'];

    protected $casts = ['show_on_home' => 'boolean'];

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
