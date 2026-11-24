<?php

namespace App\Http\Middleware;

use App\Models\Inquiry;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        $locale = session('locale', config('app.locale', 'id'));
        if (!in_array($locale, ['id', 'en'], true)) {
            $locale = 'id';
        }
        app()->setLocale($locale);

        $settings = [];
        $unreadInquiriesCount = 0;

        if (Schema::hasTable('site_settings')) {
            $settings = SiteSetting::allAsMap($locale);
        }

        if ($request->user() && Schema::hasTable('inquiries')) {
            $unreadInquiriesCount = Inquiry::where('status', 'new')->count();
        }

        return [
            ...parent::share($request),
            'locale' => $locale,
            'settings' => $settings,
            'auth' => [
                'user' => $request->user() ? [
                    'id' => $request->user()->id,
                    'name' => $request->user()->name,
                    'email' => $request->user()->email,
                    'role' => $request->user()->role ?? 'admin',
                ] : null,
            ],
            'unreadInquiriesCount' => $unreadInquiriesCount,
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'currentPath' => '/' . ltrim($request->path(), '/'),
        ];
    }
}
