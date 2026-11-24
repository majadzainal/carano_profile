<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoadmapStep;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RoadmapController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Roadmap/Index', [
            'steps' => RoadmapStep::orderBy('step_number')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateStep($request);
        RoadmapStep::create($validated);

        return back()->with('success', 'Tahapan Road Map Shipment berhasil ditambahkan.');
    }

    public function update(Request $request, RoadmapStep $roadmap): RedirectResponse
    {
        $validated = $this->validateStep($request);
        $roadmap->update($validated);

        return back()->with('success', "Tahap #{$roadmap->step_number} berhasil diperbarui.");
    }

    public function destroy(RoadmapStep $roadmap): RedirectResponse
    {
        $roadmap->delete();
        return back()->with('success', 'Tahapan Road Map berhasil dihapus.');
    }

    private function validateStep(Request $request): array
    {
        return $request->validate([
            'step_number' => ['required', 'integer', 'min:1', 'max:99'],
            'phase' => ['required', 'in:origin,sea,destination'],
            'title_id' => ['required', 'string', 'max:255'],
            'title_en' => ['required', 'string', 'max:255'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'highlights_id' => ['nullable', 'array'],
            'highlights_en' => ['nullable', 'array'],
            'icon' => ['required', 'string', 'max:50'],
            'is_active' => ['boolean'],
        ]);
    }
}
