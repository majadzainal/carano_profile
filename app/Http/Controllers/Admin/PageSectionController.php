<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PageSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PageSectionController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Sections/Index', [
            'sections' => PageSection::orderBy('page_slug')->orderBy('sort_order')->get(),
        ]);
    }

    public function update(Request $request, PageSection $section): RedirectResponse
    {
        $validated = $request->validate([
            'badge_id' => ['nullable', 'string', 'max:255'],
            'badge_en' => ['nullable', 'string', 'max:255'],
            'title_id' => ['nullable', 'string', 'max:500'],
            'title_en' => ['nullable', 'string', 'max:500'],
            'subtitle_id' => ['nullable', 'string'],
            'subtitle_en' => ['nullable', 'string'],
            'body_id' => ['nullable', 'string'],
            'body_en' => ['nullable', 'string'],
            'cta_label_id' => ['nullable', 'string', 'max:150'],
            'cta_label_en' => ['nullable', 'string', 'max:150'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'secondary_cta_label_id' => ['nullable', 'string', 'max:150'],
            'secondary_cta_label_en' => ['nullable', 'string', 'max:150'],
            'secondary_cta_url' => ['nullable', 'string', 'max:255'],
            'image_path' => ['nullable', 'string', 'max:255'],
            'extra_json' => ['nullable', 'array'],
            'is_active' => ['boolean'],
        ]);

        $section->update($validated);

        return back()->with('success', "Section \"{$section->section_label}\" berhasil diperbarui.");
    }
}
