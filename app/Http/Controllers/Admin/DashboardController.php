<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\MediaFile;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\RoadmapStep;
use App\Models\Service;
use App\Models\TradeHub;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'new_inquiries' => Inquiry::where('status', 'new')->count(),
                'total_inquiries' => Inquiry::count(),
                'published_posts' => Post::where('status', 'published')->count(),
                'draft_posts' => Post::where('status', 'draft')->count(),
                'active_services' => Service::where('is_active', true)->count(),
                'roadmap_steps' => RoadmapStep::where('is_active', true)->count(),
                'trade_hubs' => TradeHub::where('is_active', true)->count(),
                'faqs' => Faq::where('is_active', true)->count(),
                'media_files' => MediaFile::count(),
                'sections' => PageSection::count(),
            ],
            'recentInquiries' => Inquiry::latest()->limit(5)->get(),
            'recentPosts' => Post::with('author')->latest()->limit(5)->get(),
        ]);
    }
}
