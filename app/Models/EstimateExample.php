<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstimateExample extends Model
{
    protected $fillable = [
        'title', 'subtitle', 'code_label', 'area_label', 'rows', 'checklist',
        'total_label', 'total_value', 'materials_label', 'materials_value',
        'days_label', 'days_value', 'cta_label',
    ];

    protected $casts = [
        'rows' => 'array',
        'checklist' => 'array',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1], [
            'title' => 'Пример сметы',
            'subtitle' => '',
            'rows' => [],
            'checklist' => [],
            'total_value' => '0 ₽',
        ]);
    }
}
