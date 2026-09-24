<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::query()->updateOrCreate(['id' => 1], [
            'phone_e164' => '+79222371555',
            'phone_display' => '+7 (922) 237-15-55',
            'whatsapp_url' => 'https://wa.me/79222371555',
            'telegram_url' => 'https://t.me/remontologiya74',
            'email' => 'info@remontologiya.ru',
            'address_line' => 'Челябинск, по всему городу',
            'work_hours' => 'Пн–Вс, 08:00 – 20:00',
            'inn' => '745204950237',
            'brand_name' => 'Ремонтология',
            'brand_meta' => 'Челябинск · с 2016',
            'footer_about' => 'Ремонт квартир под ключ в Челябинске с 2016 года. Фиксированная цена в договоре, гарантия 24 месяца на все работы.',
            'footer_legal' => '© 2026 Ремонтология. ИНН 745204950237',
            'og_image' => '/img/hero-living-1200.webp',
            'seo_suffix' => ' | Ремонтология',
        ]);
    }
}
