<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Inquiry;
use App\Models\PageSection;
use App\Models\Post;
use App\Models\RoadmapStep;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\TradeHub;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PublicController extends Controller
{
    private function currentLocale(): string
    {
        $locale = session('locale', config('app.locale', 'id'));
        return in_array($locale, ['id', 'en'], true) ? $locale : 'id';
    }

    private function sectionsFor(string $pageSlug, string $locale): array
    {
        $rows = PageSection::where('page_slug', $pageSlug)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $mapped = [];
        foreach ($rows as $row) {
            $mapped[$row->section_key] = $row->localized($locale);
        }
        return $mapped;
    }

    private function seo(string $title, ?string $description = null, ?string $image = null): array
    {
        $locale = $this->currentLocale();
        $defaultDesc = SiteSetting::getValue('seo_default_description', $locale, '');
        return [
            'title' => $title,
            'description' => $description ?: $defaultDesc,
            'image' => $image ? url($image) : url('/images/brand/logo-carano-light.png'),
        ];
    }

    public function home(): Response
    {
        $locale = $this->currentLocale();
        $defaultTitle = SiteSetting::getValue('seo_default_title', $locale, 'PT. CARANO UTAMA LOGISTIK');

        return Inertia::render('Public/Home', [
            'sections' => $this->sectionsFor('home', $locale),
            'roadmapSteps' => RoadmapStep::where('is_active', true)->orderBy('step_number')->get()->map->localized($locale),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'tradeHubs' => TradeHub::where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'posts' => Post::with('author')->where('status', 'published')->orderByDesc('published_at')->limit(3)->get()->map->localized($locale),
            'faqs' => Faq::where('is_active', true)->orderBy('sort_order')->limit(6)->get()->map->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($defaultTitle),
        ]);
    }

    public function services(): Response
    {
        $locale = $this->currentLocale();
        return Inertia::render('Public/Services', [
            'intro' => PageSection::where('section_key', 'home_services_intro')->first()?->localized($locale),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'cta' => PageSection::where('section_key', 'home_cta')->first()?->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($locale === 'en' ? 'Services — PT. CARANO UTAMA LOGISTIK' : 'Layanan Logistik — PT. CARANO UTAMA LOGISTIK'),
        ]);
    }

    public function serviceDetail(string $slug): Response
    {
        $locale = $this->currentLocale();
        $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $localized = $service->localized($locale);
        $others = Service::where('is_active', true)->where('id', '!=', $service->id)->orderBy('sort_order')->get()->map->localized($locale);

        return Inertia::render('Public/ServiceDetail', [
            'service' => $localized,
            'otherServices' => $others,
            'roadmapSteps' => RoadmapStep::where('is_active', true)->orderBy('step_number')->get()->map->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($localized['title'] . ' — PT. CARANO UTAMA LOGISTIK', $localized['short_desc'], $localized['image_path']),
        ]);
    }

    public function roadmap(): Response
    {
        $locale = $this->currentLocale();
        return Inertia::render('Public/Roadmap', [
            'intro' => PageSection::where('section_key', 'home_roadmap_intro')->first()?->localized($locale),
            'roadmapSteps' => RoadmapStep::where('is_active', true)->orderBy('step_number')->get()->map->localized($locale),
            'cta' => PageSection::where('section_key', 'home_cta')->first()?->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($locale === 'en' ? '10-Step Shipment Road Map — PT. CARANO UTAMA LOGISTIK' : 'Road Map Shipment 10 Tahap — PT. CARANO UTAMA LOGISTIK'),
        ]);
    }

    public function network(): Response
    {
        $locale = $this->currentLocale();
        return Inertia::render('Public/Network', [
            'intro' => PageSection::where('section_key', 'home_network_intro')->first()?->localized($locale),
            'tradeHubs' => TradeHub::where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'cta' => PageSection::where('section_key', 'home_cta')->first()?->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($locale === 'en' ? 'Trade Corridor Network — PT. CARANO UTAMA LOGISTIK' : 'Jaringan Rute & Pelabuhan — PT. CARANO UTAMA LOGISTIK'),
        ]);
    }

    public function about(): Response
    {
        $locale = $this->currentLocale();
        return Inertia::render('Public/About', [
            'story' => PageSection::where('section_key', 'about_story')->first()?->localized($locale),
            'whyUs' => PageSection::where('section_key', 'home_why_us')->first()?->localized($locale),
            'metrics' => PageSection::where('section_key', 'home_metrics')->first()?->localized($locale),
            'cta' => PageSection::where('section_key', 'home_cta')->first()?->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($locale === 'en' ? 'About Us — PT. CARANO UTAMA LOGISTIK' : 'Tentang Kami — PT. CARANO UTAMA LOGISTIK'),
        ]);
    }

    public function insights(Request $request): Response
    {
        $locale = $this->currentLocale();
        $category = $request->string('category')->toString();

        $query = Post::with('author')
            ->where('status', 'published')
            ->orderByDesc('published_at');

        if ($category !== '') {
            $query->where('category', $category);
        }

        $categories = Post::where('status', 'published')
            ->select('category')
            ->distinct()
            ->pluck('category');

        return Inertia::render('Public/Insights', [
            'posts' => $query->get()->map->localized($locale),
            'categories' => $categories,
            'activeCategory' => $category,
            'faqs' => Faq::where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
        ])->withViewData([
            'seo' => $this->seo($locale === 'en' ? 'Logistics Insights & FAQ — PT. CARANO UTAMA LOGISTIK' : 'Insight Logistik & FAQ — PT. CARANO UTAMA LOGISTIK'),
        ]);
    }

    public function insightDetail(string $slug): Response
    {
        $locale = $this->currentLocale();
        $post = Post::with('author')->where('slug', $slug)->where('status', 'published')->firstOrFail();
        $localized = $post->localized($locale);
        $related = Post::with('author')
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->orderByDesc('published_at')
            ->limit(3)
            ->get()
            ->map->localized($locale);

        return Inertia::render('Public/InsightDetail', [
            'post' => $localized,
            'relatedPosts' => $related,
        ])->withViewData([
            'seo' => $this->seo(
                $localized['meta_title'] ?: ($localized['title'] . ' — PT. CARANO UTAMA LOGISTIK'),
                $localized['meta_description'] ?: $localized['excerpt'],
                $localized['featured_image']
            ),
        ]);
    }

    public function contact(Request $request): Response
    {
        $locale = $this->currentLocale();
        return Inertia::render('Public/Contact', [
            'origins' => TradeHub::where('type', 'origin')->where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'destinations' => TradeHub::where('type', 'destination')->where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'services' => Service::where('is_active', true)->orderBy('sort_order')->get()->map->localized($locale),
            'faqs' => Faq::where('is_active', true)->orderBy('sort_order')->limit(4)->get()->map->localized($locale),
            'prefill' => $request->only(['direction', 'origin', 'destination', 'service', 'notes']),
        ])->withViewData([
            'seo' => $this->seo($locale === 'en' ? 'Contact & Request a Quote — PT. CARANO UTAMA LOGISTIK' : 'Kontak & Minta Penawaran — PT. CARANO UTAMA LOGISTIK'),
        ]);
    }

    public function submitInquiry(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:150'],
            'contact_name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['required', 'string', 'max:50'],
            'origin_country' => ['nullable', 'string', 'max:80'],
            'destination_port' => ['nullable', 'string', 'max:80'],
            'service_type' => ['nullable', 'string', 'max:120'],
            'cargo_details' => ['required', 'string', 'max:2500'],
        ]);

        Inquiry::create([
            ...$validated,
            'status' => 'new',
        ]);

        $locale = $this->currentLocale();
        $message = $locale === 'en'
            ? 'Thank you! Your quotation request has been received. Our logistics team will contact you shortly.'
            : 'Terima kasih! Permintaan penawaran Anda telah kami terima. Tim logistik PT. CARANO UTAMA LOGISTIK akan segera menghubungi Anda.';

        return back()->with('success', $message);
    }

    public function switchLocale(string $locale): RedirectResponse
    {
        if (in_array($locale, ['id', 'en'], true)) {
            session(['locale' => $locale]);
        }
        return back();
    }
}
