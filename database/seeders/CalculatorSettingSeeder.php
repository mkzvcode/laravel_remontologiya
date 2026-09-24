<?php

namespace Database\Seeders;

use App\Models\CalculatorSetting;
use Illuminate\Database\Seeder;

class CalculatorSettingSeeder extends Seeder
{
    public function run(): void
    {
        CalculatorSetting::query()->updateOrCreate(['id' => 1], [
            'area_min' => 20, 'area_max' => 150, 'area_default' => 50,
            'default_type' => 'kap',

            'type_cos_label' => 'Косметический', 'base_cos' => 4500, 'factor_cos' => 0.5,
            'type_kap_label' => 'Капитальный', 'base_kap' => 8900, 'factor_kap' => 1.12,
            'type_diz_label' => 'Дизайнерский', 'base_diz' => 15900, 'factor_diz' => 1.6,

            'opt_demo_label' => 'Демонтаж старой отделки', 'opt_demo_price' => 700, 'opt_demo_default' => true,
            'opt_elec_label' => 'Полная замена электрики', 'opt_elec_price' => 900, 'opt_elec_default' => true,
            'opt_plumb_label' => 'Замена труб и сантехники', 'opt_plumb_price' => 750, 'opt_plumb_default' => false,
            'opt_plan_label' => 'Перепланировка с проектом', 'opt_plan_price' => 1100, 'opt_plan_default' => false,
            'opt_design_label' => 'Дизайн-проект', 'opt_design_price' => 1200, 'opt_design_default' => false,
            'opt_furn_label' => 'Сборка и монтаж мебели', 'opt_furn_price' => 500, 'opt_furn_default' => false,
        ]);
    }
}
