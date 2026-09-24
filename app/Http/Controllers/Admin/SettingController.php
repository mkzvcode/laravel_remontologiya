<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['setting' => Setting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'phone_e164' => ['required', 'string', 'max:32'],
            'phone_display' => ['required', 'string', 'max:32'],
            'whatsapp_url' => ['nullable', 'url', 'max:255'],
            'telegram_url' => ['nullable', 'url', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'address_line' => ['nullable', 'string', 'max:255'],
            'work_hours' => ['nullable', 'string', 'max:255'],
            'inn' => ['nullable', 'string', 'max:32'],
            'brand_name' => ['required', 'string', 'max:64'],
            'brand_meta' => ['required', 'string', 'max:64'],
            'footer_about' => ['nullable', 'string', 'max:1000'],
            'footer_legal' => ['nullable', 'string', 'max:255'],
            'seo_suffix' => ['nullable', 'string', 'max:64'],
            'ga_id' => ['nullable', 'string', 'max:64'],
            'metrika_id' => ['nullable', 'string', 'max:64'],
        ]);

        Setting::current()->update($data);

        return back()->with('status', 'Настройки сохранены.');
    }
}
