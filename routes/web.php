<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\PageSectionController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\RoadmapController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TradeHubController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

// Public Website Routes
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/layanan', [PublicController::class, 'services'])->name('services');
Route::get('/layanan/{slug}', [PublicController::class, 'serviceDetail'])->name('services.show');
Route::get('/alur-pengiriman', [PublicController::class, 'roadmap'])->name('roadmap');
Route::get('/jaringan-rute', [PublicController::class, 'network'])->name('network');
Route::get('/tentang-kami', [PublicController::class, 'about'])->name('about');
Route::get('/insight', [PublicController::class, 'insights'])->name('insights');
Route::get('/insight/{slug}', [PublicController::class, 'insightDetail'])->name('insights.show');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');
Route::post('/kontak/inquiry', [PublicController::class, 'submitInquiry'])->name('contact.inquiry');
Route::post('/locale/{locale}', [PublicController::class, 'switchLocale'])->name('locale.switch');

// Admin Auth Routes
Route::prefix('carano-admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

    // Protected WordPress-style CMS Backend
    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Page Sections Editor
        Route::get('/sections', [PageSectionController::class, 'index'])->name('sections.index');
        Route::put('/sections/{section}', [PageSectionController::class, 'update'])->name('sections.update');

        // 10-Step Shipment Roadmap CRUD
        Route::get('/roadmap', [RoadmapController::class, 'index'])->name('roadmap.index');
        Route::post('/roadmap', [RoadmapController::class, 'store'])->name('roadmap.store');
        Route::put('/roadmap/{roadmap}', [RoadmapController::class, 'update'])->name('roadmap.update');
        Route::delete('/roadmap/{roadmap}', [RoadmapController::class, 'destroy'])->name('roadmap.destroy');

        // Services CRUD
        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
        Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
        Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');

        // Trade Hubs / Routes CRUD
        Route::get('/routes', [TradeHubController::class, 'index'])->name('routes.index');
        Route::post('/routes', [TradeHubController::class, 'store'])->name('routes.store');
        Route::put('/routes/{tradeHub}', [TradeHubController::class, 'update'])->name('routes.update');
        Route::delete('/routes/{tradeHub}', [TradeHubController::class, 'destroy'])->name('routes.destroy');

        // Articles / Insights (WordPress-style Posts)
        Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
        Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
        Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
        Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

        // FAQs CRUD
        Route::get('/faqs', [FaqController::class, 'index'])->name('faqs.index');
        Route::post('/faqs', [FaqController::class, 'store'])->name('faqs.store');
        Route::put('/faqs/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('/faqs/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');

        // Media Library
        Route::get('/media', [MediaController::class, 'index'])->name('media.index');
        Route::get('/media/list', [MediaController::class, 'listJson'])->name('media.list');
        Route::post('/media', [MediaController::class, 'store'])->name('media.store');
        Route::delete('/media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');

        // Inquiries / RFQ Inbox
        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/export', [InquiryController::class, 'exportCsv'])->name('inquiries.export');
        Route::put('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update');
        Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

        // Site Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // CMS Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    });
});
