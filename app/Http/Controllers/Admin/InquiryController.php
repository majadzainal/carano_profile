<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class InquiryController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Inquiry::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        return Inertia::render('Admin/Inquiries/Index', [
            'inquiries' => $query->get(),
            'filters' => $request->only(['status']),
        ]);
    }

    public function update(Request $request, Inquiry $inquiry): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,in_progress,quoted,closed'],
            'admin_notes' => ['nullable', 'string'],
        ]);

        $inquiry->update($validated);
        return back()->with('success', 'Status permintaan penawaran berhasil diperbarui.');
    }

    public function destroy(Inquiry $inquiry): RedirectResponse
    {
        $inquiry->delete();
        return back()->with('success', 'Data penawaran berhasil dihapus.');
    }

    public function exportCsv(): StreamedResponse
    {
        $filename = 'carano-inquiries-' . now()->format('Ymd-His') . '.csv';
        $rows = Inquiry::latest()->get();

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Tanggal', 'Perusahaan', 'Nama Kontak', 'Email', 'Telepon', 'Negara Asal', 'Pelabuhan Tujuan', 'Layanan', 'Detail Kargo', 'Status', 'Catatan Admin']);
            foreach ($rows as $row) {
                fputcsv($handle, [
                    $row->created_at?->format('Y-m-d H:i'),
                    $row->company_name,
                    $row->contact_name,
                    $row->email,
                    $row->phone,
                    $row->origin_country,
                    $row->destination_port,
                    $row->service_type,
                    $row->cargo_details,
                    $row->status,
                    $row->admin_notes,
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
