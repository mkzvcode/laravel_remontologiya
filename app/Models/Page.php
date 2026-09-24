<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug', 'nav_key', 'meta_title', 'meta_description', 'og_image',
        'hero_eyebrow', 'hero_title_html', 'hero_lead',
        'hero_cta1_label', 'hero_cta1_href', 'hero_cta2_label', 'hero_cta2_href',
        'hero_image', 'hero_image_alt',
        'hero_badge_label', 'hero_badge_sum', 'hero_badge_note',
        'hero_caption_meta', 'hero_caption_title', 'hero_caption_term', 'hero_caption_note',
        'stat1_num', 'stat1_label', 'stat2_num', 'stat2_label', 'stat3_num', 'stat3_label',
        'hero_stats', 'marquee_items', 'sections',
    ];

    protected $casts = [
        'hero_stats' => 'array',
        'marquee_items' => 'array',
        'sections' => 'array',
    ];

    public static function bySlug(string $slug): self
    {
        return static::query()->where('slug', $slug)->firstOrFail();
    }

    /** Текст раздела (eyebrow/title/lead) по ключу секции с безопасным фолбэком. */
    public function section(string $key): array
    {
        $data = $this->sections[$key] ?? [];

        return [
            'eyebrow' => $data['eyebrow'] ?? '',
            'title_html' => $data['title_html'] ?? '',
            'lead' => $data['lead'] ?? '',
        ];
    }
}
