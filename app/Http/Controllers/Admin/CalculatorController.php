<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalculatorSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalculatorController extends Controller
{
    public function edit(): View
    {
        return view('admin.calculator.edit', ['calc' => CalculatorSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'area_min' => ['required', 'integer', 'min:1', 'max:1000'],
            'area_max' => ['required', 'integer', 'gt:area_min', 'max:2000'],
            'area_default' => ['required', 'integer', 'min:1', 'max:2000'],
            'default_type' => ['required', 'in:cos,kap,diz'],

            'type_cos_label' => ['required', 'string', 'max:64'],
            'base_cos' => ['required', 'integer', 'min:0'],
            'factor_cos' => ['required', 'numeric', 'min:0'],

            'type_kap_label' => ['required', 'string', 'max:64'],
            'base_kap' => ['required', 'integer', 'min:0'],
            'factor_kap' => ['required', 'numeric', 'min:0'],

            'type_diz_label' => ['required', 'string', 'max:64'],
            'base_diz' => ['required', 'integer', 'min:0'],
            'factor_diz' => ['required', 'numeric', 'min:0'],

            'opt_demo_label' => ['required', 'string', 'max:255'],
            'opt_demo_price' => ['required', 'integer', 'min:0'],
            'opt_demo_default' => ['nullable'],

            'opt_elec_label' => ['required', 'string', 'max:255'],
            'opt_elec_price' => ['required', 'integer', 'min:0'],
            'opt_elec_default' => ['nullable'],

            'opt_plumb_label' => ['required', 'string', 'max:255'],
            'opt_plumb_price' => ['required', 'integer', 'min:0'],
            'opt_plumb_default' => ['nullable'],

            'opt_plan_label' => ['required', 'string', 'max:255'],
            'opt_plan_price' => ['required', 'integer', 'min:0'],
            'opt_plan_default' => ['nullable'],

            'opt_design_label' => ['required', 'string', 'max:255'],
            'opt_design_price' => ['required', 'integer', 'min:0'],
            'opt_design_default' => ['nullable'],

            'opt_furn_label' => ['required', 'string', 'max:255'],
            'opt_furn_price' => ['required', 'integer', 'min:0'],
            'opt_furn_default' => ['nullable'],
        ]);

        foreach (['demo', 'elec', 'plumb', 'plan', 'design', 'furn'] as $key) {
            $data["opt_{$key}_default"] = $request->boolean("opt_{$key}_default");
        }

        CalculatorSetting::current()->update($data);

        return back()->with('status', 'Настройки калькулятора сохранены.');
    }
}
