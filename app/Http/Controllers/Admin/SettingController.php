<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Settings/Index', [
            'settings' => SiteSetting::orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'integer', 'exists:site_settings,id'],
            'items.*.value_id' => ['nullable', 'string'],
            'items.*.value_en' => ['nullable', 'string'],
        ]);

        foreach ($validated['items'] as $item) {
            SiteSetting::where('id', $item['id'])->update([
                'value_id' => $item['value_id'] ?? '',
                'value_en' => $item['value_en'] ?? ($item['value_id'] ?? ''),
            ]);
        }

        return back()->with('success', 'Pengaturan situs berhasil disimpan.');
    }
}
