<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TradeHub;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TradeHubController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Routes/Index', [
            'hubs' => TradeHub::orderBy('type')->orderBy('sort_order')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        TradeHub::create($this->validateHub($request));
        return back()->with('success', 'Hub rute/pelabuhan berhasil ditambahkan.');
    }

    public function update(Request $request, TradeHub $tradeHub): RedirectResponse
    {
        $tradeHub->update($this->validateHub($request));
        return back()->with('success', "Hub \"{$tradeHub->name_id}\" berhasil diperbarui.");
    }

    public function destroy(TradeHub $tradeHub): RedirectResponse
    {
        $tradeHub->delete();
        return back()->with('success', 'Hub rute berhasil dihapus.');
    }

    private function validateHub(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:origin,destination'],
            'code' => ['nullable', 'string', 'max:20'],
            'name_id' => ['required', 'string', 'max:150'],
            'name_en' => ['required', 'string', 'max:150'],
            'country' => ['required', 'string', 'max:80'],
            'description_id' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'map_x' => ['required', 'numeric', 'min:0', 'max:1000'],
            'map_y' => ['required', 'numeric', 'min:0', 'max:600'],
            'sort_order' => ['integer', 'min:0'],
            'is_active' => ['boolean'],
        ]);
    }
}
