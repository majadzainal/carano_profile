<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Services/Index', [
            'services' => Service::orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateService($request);
        $data['slug'] = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['title_id']);

        Service::create($data);

        return back()->with('success', 'Layanan baru berhasil ditambahkan.');
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validateService($request, $service->id);
        $data['slug'] = filled($data['slug'] ?? null)
            ? Str::slug($data['slug'])
            : Str::slug($data['title_id']);

        $service->update($data);

        return back()->with('success', "Layanan \"{$service->title_id}\" berhasil diperbarui.");
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();
        return back()->with('success', 'Layanan berhasil dihapus.');
    }

    private function validateService(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'slug' => ['nullable', 'string', 'max:120', Rule::unique('services', 'slug')->ignore($ignoreId)],
            'badge_id' => ['nullable', 'string', 'max:100'],
            'badge_en' => ['nullable', 'string', 'max:100'],
            'title_id' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'short_desc_id' => ['nullable', 'string'],
            'short_desc_en' => ['nullable', 'string'],
            'body_id' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:50'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'features_id' => ['nullable', 'array'],
            'features_en' => ['nullable', 'array'],
            'sort_order' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);
    }
}
