<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'phone_e164', 'phone_display', 'whatsapp_url', 'telegram_url', 'email',
        'address_line', 'work_hours', 'inn', 'brand_name', 'brand_meta',
        'footer_about', 'footer_legal', 'og_image', 'seo_suffix', 'ga_id', 'metrika_id',
    ];

    /**
     * Настройки одни на весь сайт — всегда работаем со строкой id=1,
     * создавая её при первом обращении, если ещё нет.
     */
    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }
}
