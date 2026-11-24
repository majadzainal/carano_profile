<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaFile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class MediaController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Media/Index', [
            'files' => MediaFile::with('uploader')->latest()->get(),
        ]);
    }

    public function listJson(): JsonResponse
    {
        return response()->json([
            'files' => MediaFile::latest()->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240', 'mimes:jpg,jpeg,png,webp,gif,svg,pdf'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $uploaded = $request->file('file');
        $ext = strtolower($uploaded->getClientOriginalExtension());
        $isPdf = $ext === 'pdf';
        $subDir = $isPdf ? 'uploads/docs' : 'uploads/images';
        $targetDir = public_path($subDir);

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0775, true);
        }

        $safeBase = Str::slug(pathinfo($uploaded->getClientOriginalName(), PATHINFO_FILENAME));
        $filename = ($safeBase ?: 'file') . '-' . time() . '.' . $ext;
        $mimeType = $uploaded->getMimeType();
        $size = $uploaded->getSize();
        $originalName = $uploaded->getClientOriginalName();

        $uploaded->move($targetDir, $filename);

        $media = MediaFile::create([
            'filename' => $filename,
            'original_name' => $originalName,
            'file_path' => '/' . $subDir . '/' . $filename,
            'mime_type' => $mimeType,
            'file_size' => $size,
            'alt_text' => $request->string('alt_text')->toString() ?: $originalName,
            'uploaded_by' => $request->user()->id,
        ]);

        if ($request->wantsJson() && !$request->header('X-Inertia')) {
            return response()->json(['file' => $media], 201);
        }

        return back()->with('success', 'File berhasil diunggah ke Media Library.');
    }

    public function destroy(MediaFile $media): RedirectResponse
    {
        // Only unlink files inside public/uploads/ (never delete core brand images accidentally)
        if (str_starts_with($media->file_path, '/uploads/')) {
            $full = public_path(ltrim($media->file_path, '/'));
            if (file_exists($full)) {
                @unlink($full);
            }
        }

        $media->delete();
        return back()->with('success', 'File berhasil dihapus dari Media Library.');
    }
}
