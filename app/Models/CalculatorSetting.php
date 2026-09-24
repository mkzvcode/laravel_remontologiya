<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CalculatorSetting extends Model
{
    protected $fillable = [
        'area_min', 'area_max', 'area_default',
        'type_cos_label', 'base_cos', 'factor_cos',
        'type_kap_label', 'base_kap', 'factor_kap',
        'type_diz_label', 'base_diz', 'factor_diz',
        'default_type',
        'opt_demo_label', 'opt_demo_price', 'opt_demo_default',
        'opt_elec_label', 'opt_elec_price', 'opt_elec_default',
        'opt_plumb_label', 'opt_plumb_price', 'opt_plumb_default',
        'opt_plan_label', 'opt_plan_price', 'opt_plan_default',
        'opt_design_label', 'opt_design_price', 'opt_design_default',
        'opt_furn_label', 'opt_furn_price', 'opt_furn_default',
    ];

    protected $casts = [
        'factor_cos' => 'float',
        'factor_kap' => 'float',
        'factor_diz' => 'float',
        'opt_demo_default' => 'boolean',
        'opt_elec_default' => 'boolean',
        'opt_plumb_default' => 'boolean',
        'opt_plan_default' => 'boolean',
        'opt_design_default' => 'boolean',
        'opt_furn_default' => 'boolean',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate(['id' => 1]);
    }

    /** Готовая структура для JS-калькулятора на клиенте. */
    public function toJsSettings(): array
    {
        $opts = [];
        foreach (['demo', 'elec', 'plumb', 'plan', 'design', 'furn'] as $k) {
            $opts[$k] = [
                'label' => $this->{"opt_{$k}_label"},
                'price' => (int) $this->{"opt_{$k}_price"},
                'default' => (bool) $this->{"opt_{$k}_default"},
            ];
        }

        return [
            'areaMin' => (int) $this->area_min,
            'areaMax' => (int) $this->area_max,
            'areaDefault' => (int) $this->area_default,
            'defaultType' => $this->default_type,
            'types' => [
                'cos' => ['label' => $this->type_cos_label, 'base' => (int) $this->base_cos, 'factor' => (float) $this->factor_cos],
                'kap' => ['label' => $this->type_kap_label, 'base' => (int) $this->base_kap, 'factor' => (float) $this->factor_kap],
                'diz' => ['label' => $this->type_diz_label, 'base' => (int) $this->base_diz, 'factor' => (float) $this->factor_diz],
            ],
            'options' => $opts,
        ];
    }
}
