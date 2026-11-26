<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $seoTitle = $seo['title'] ?? 'PT. CARANO UTAMA LOGISTIK — Integrated International Export & Import Freight Forwarder';
        $seoDescription = $seo['description'] ?? 'PT. CARANO UTAMA LOGISTIK menyediakan solusi logistik ekspor dan impor end-to-end (Sea Freight, Air Freight, Customs Clearance PEB/PIB & Trucking) menghubungkan Indonesia dengan Jepang, China, Taiwan, Korea, Singapura & global.';
        $seoImage = $seo['image'] ?? asset('images/brand/logo-carano-light.png');
    @endphp

    <title inertia>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="twitter:card" content="summary_large_image">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/brand/apple-touch-icon.png') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <script type="application/ld+json">
        {!! json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'PT. CARANO UTAMA LOGISTIK',
            'url' => url('/'),
            'logo' => asset('images/brand/logo-carano-light.png'),
            'description' => $seoDescription,
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @inertiaHead
</head>
<body class="antialiased bg-white text-slate-900 w-full max-w-[100vw] overflow-x-clip selection:bg-gold-400/30 selection:text-navy-900">
    @inertia
</body>
</html>
