<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EstimateExample;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EstimateController extends Controller
{
    public function edit(): View
    {
        return view('admin.estimate.edit', ['estimate' => EstimateExample::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['required', 'string', 'max:2000'],
            'code_label' => ['nullable', 'string', 'max:64'],
            'area_label' => ['nullable', 'string', 'max:64'],
            'total_label' => ['required', 'string', 'max:64'],
            'total_value' => ['required', 'string', 'max:32'],
            'materials_label' => ['required', 'string', 'max:64'],
            'materials_value' => ['nullable', 'string', 'max:32'],
            'days_label' => ['required', 'string', 'max:64'],
            'days_value' => ['nullable', 'string', 'max:32'],
            'cta_label' => ['required', 'string', 'max:64'],
        ]);

        $data['rows'] = collect($request->input('rows', []))
            ->filter(fn ($r) => trim($r['name'] ?? '') !== '' || trim($r['price'] ?? '') !== '')
            ->map(fn ($r) => ['name' => trim($r['name'] ?? ''), 'price' => trim($r['price'] ?? '')])
            ->values()->all();

        $data['checklist'] = collect($request->input('checklist', []))
            ->map(fn ($v) => trim((string) $v))
            ->filter()
            ->values()->all();

        EstimateExample::current()->update($data);

        return back()->with('status', 'Пример сметы сохранён.');
    }
}
