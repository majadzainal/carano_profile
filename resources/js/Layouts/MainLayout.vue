<script setup>
import { computed, ref, onMounted, onUnmounted } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import {
    ArrowUpRight,
    Clock,
    Download,
    Globe,
    Mail,
    MapPin,
    Menu,
    MessageCircle,
    Phone,
    X,
} from 'lucide-vue-next';

const page = usePage();
const settings = computed(() => page.props.settings || {});
const locale = computed(() => page.props.locale || 'id');
const currentPath = computed(() => page.props.currentPath || '/');

const mobileMenuOpen = ref(false);
const isScrolled = ref(false);

const navItems = computed(() =>
    locale.value === 'en'
        ? [
              { label: 'Home', href: '/' },
              { label: 'Services', href: '/layanan' },
              { label: 'Road Map', href: '/alur-pengiriman' },
              { label: 'Network', href: '/jaringan-rute' },
              { label: 'About Us', href: '/tentang-kami' },
              { label: 'Insights', href: '/insight' },
          ]
        : [
              { label: 'Beranda', href: '/' },
              { label: 'Layanan', href: '/layanan' },
              { label: 'Road Map', href: '/alur-pengiriman' },
              { label: 'Jaringan Rute', href: '/jaringan-rute' },
              { label: 'Tentang Kami', href: '/tentang-kami' },
              { label: 'Insight', href: '/insight' },
          ]
);

const isActive = (href) => {
    if (href === '/') return currentPath.value === '/';
    return currentPath.value.startsWith(href);
};

const switchLocale = (target) => {
    if (target === locale.value) return;
    router.post(`/locale/${target}`, {}, { preserveScroll: true });
};

const whatsappUrl = computed(() => {
    const num = (settings.value.contact_whatsapp || '6281234567890').replace(/[^0-9]/g, '');
    const msg =
        locale.value === 'en'
            ? 'Hello PT. CARANO UTAMA LOGISTIK, I would like to inquire about import shipping services.'
            : 'Halo PT. CARANO UTAMA LOGISTIK, saya ingin berkonsultasi mengenai layanan pengiriman impor.';
    return `https://wa.me/${num}?text=${encodeURIComponent(msg)}`;
});

const onScroll = () => {
    isScrolled.value = window.scrollY > 16;
};

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onUnmounted(() => window.removeEventListener('scroll', onScroll));
</script>

<template>
    <div class="min-h-screen flex flex-col bg-white text-slate-900">
        <!-- Sticky Enterprise Header (Hacobu-inspired) -->
        <header
            class="sticky top-0 z-50 transition-all duration-300"
            :class="
                isScrolled
                    ? 'bg-white/95 backdrop-blur-md shadow-[0_6px_30px_rgba(7,26,62,0.07)] border-b border-slate-200/80'
                    : 'bg-white border-b border-slate-100'
            "
        >
            <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4 h-20">
                    <!-- Brand Logo -->
                    <Link href="/" class="flex items-center gap-3 group shrink-0">
                        <img
                            :src="settings.logo_mark || '/images/brand/logo-carano-mark.png'"
                            :alt="settings.company_name || 'PT. CARANO UTAMA LOGISTIK'"
                            class="h-11 w-11 object-contain transition-transform duration-300 group-hover:scale-105 shrink-0"
                        />
                        <div class="leading-tight whitespace-nowrap">
                            <span class="block text-sm sm:text-[15px] font-extrabold tracking-tight text-navy-900">
                                {{ settings.company_name || 'PT. CARANO UTAMA LOGISTIK' }}
                            </span>
                            <span class="block text-[9px] font-bold tracking-wider text-gold-600 uppercase">
                                INTERNATIONAL FREIGHT FORWARDER COMPANY
                            </span>
                        </div>
                    </Link>

                    <!-- Desktop Nav (Guaranteed Single-Line) -->
                    <nav class="hidden xl:flex items-center gap-1 shrink-0">
                        <Link
                            v-for="item in navItems"
                            :key="item.href"
                            :href="item.href"
                            class="relative px-3 py-2 text-sm font-medium rounded-lg transition-colors whitespace-nowrap shrink-0"
                            :class="
                                isActive(item.href)
                                    ? 'text-navy-900 font-semibold'
                                    : 'text-slate-600 hover:text-navy-900 hover:bg-slate-50'
                            "
                        >
                            {{ item.label }}
                            <span
                                v-if="isActive(item.href)"
                                class="absolute bottom-0.5 left-3 right-3 h-0.5 bg-gold-500 rounded-full"
                            />
                        </Link>
                    </nav>

                    <!-- Right Actions (Guaranteed Single-Line) -->
                    <div class="hidden xl:flex items-center gap-2.5 shrink-0">
                        <!-- Locale Switcher -->
                        <div class="inline-flex items-center rounded-full bg-slate-100 p-0.5 border border-slate-200/70 shrink-0">
                            <button
                                type="button"
                                @click="switchLocale('id')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-full transition-all cursor-pointer whitespace-nowrap"
                                :class="
                                    locale === 'id'
                                        ? 'bg-navy-900 text-white shadow-xs'
                                        : 'text-slate-600 hover:text-navy-900'
                                "
                            >
                                ID
                            </button>
                            <button
                                type="button"
                                @click="switchLocale('en')"
                                class="px-2.5 py-1 text-xs font-semibold rounded-full transition-all cursor-pointer whitespace-nowrap"
                                :class="
                                    locale === 'en'
                                        ? 'bg-navy-900 text-white shadow-xs'
                                        : 'text-slate-600 hover:text-navy-900'
                                "
                            >
                                EN
                            </button>
                        </div>

                        <a
                            :href="settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold text-navy-900 border border-navy-800/20 rounded-full hover:border-navy-800 hover:bg-ocean-50 transition-all whitespace-nowrap shrink-0"
                        >
                            <Download :size="14" class="shrink-0" />
                            <span>{{ locale === 'en' ? 'Road Map PDF' : 'Unduh PDF' }}</span>
                        </a>

                        <Link
                            href="/kontak"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 text-xs font-bold text-navy-950 bg-gold-500 hover:bg-gold-400 rounded-full shadow-sm hover:shadow transition-all whitespace-nowrap shrink-0"
                        >
                            <span>{{ locale === 'en' ? 'Request Quote' : 'Minta Penawaran' }}</span>
                            <ArrowUpRight :size="15" class="shrink-0" />
                        </Link>
                    </div>

                    <!-- Mobile / Tablet Menu Trigger -->
                    <div class="flex xl:hidden items-center gap-2 shrink-0">
                        <button
                            type="button"
                            @click="switchLocale(locale === 'id' ? 'en' : 'id')"
                            class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-semibold rounded-lg bg-slate-100 text-navy-900 whitespace-nowrap"
                        >
                            <Globe :size="14" />
                            {{ locale.toUpperCase() }}
                        </button>
                        <button
                            type="button"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            class="p-2 rounded-lg text-navy-900 hover:bg-slate-100"
                            aria-label="Toggle navigation"
                        >
                            <X v-if="mobileMenuOpen" :size="24" />
                            <Menu v-else :size="24" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile / Tablet Drawer -->
            <div v-if="mobileMenuOpen" class="xl:hidden bg-white border-t border-slate-100 shadow-lg">
                <div class="px-4 pt-3 pb-5 space-y-1">
                    <Link
                        v-for="item in navItems"
                        :key="item.href"
                        :href="item.href"
                        @click="mobileMenuOpen = false"
                        class="block px-3.5 py-2.5 rounded-xl text-sm font-semibold"
                        :class="
                            isActive(item.href)
                                ? 'bg-ocean-50 text-navy-900 border-l-4 border-gold-500'
                                : 'text-slate-600 hover:bg-slate-50'
                        "
                    >
                        {{ item.label }}
                    </Link>
                    <div class="pt-3 flex flex-col gap-2">
                        <a
                            :href="settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                            target="_blank"
                            class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-semibold text-navy-900 border border-slate-300 rounded-xl"
                        >
                            <Download :size="16" />
                            {{ locale === 'en' ? 'Download Road Map PDF' : 'Unduh Road Map PDF' }}
                        </a>
                        <Link
                            href="/kontak"
                            @click="mobileMenuOpen = false"
                            class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-bold text-navy-950 bg-gold-500 rounded-xl"
                        >
                            {{ locale === 'en' ? 'Request a Quote' : 'Minta Penawaran' }}
                            <ArrowUpRight :size="16" />
                        </Link>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Enterprise Footer (Deep Royal Navy) -->
        <footer class="bg-navy-950 text-slate-300 border-t border-white/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10">
                    <!-- Brand Column -->
                    <div class="lg:col-span-4 space-y-5">
                        <div class="flex items-center gap-3.5">
                            <img
                                :src="settings.logo_dark || '/images/brand/logo-carano-dark.png'"
                                :alt="settings.company_name || 'PT. CARANO UTAMA LOGISTIK'"
                                class="h-16 w-16 object-contain"
                            />
                            <div>
                                <div class="text-white font-extrabold text-lg tracking-tight">
                                    {{ settings.company_name || 'PT. CARANO UTAMA LOGISTIK' }}
                                </div>
                                <div class="text-xs text-gold-400 font-medium mt-0.5">
                                    {{ settings.company_tagline }}
                                </div>
                            </div>
                        </div>
                        <p class="text-sm text-slate-400 leading-relaxed">
                            {{
                                locale === 'en'
                                    ? 'Integrated sea freight, origin handling, customs clearance, and multimodal delivery connecting East Asia’s industrial hubs with Indonesia’s primary maritime gateways.'
                                    : 'Layanan logistik impor terintegrasi mencakup sea freight, origin handling, kepabeanan bea cukai, serta distribusi darat & udara yang menghubungkan pusat industri Asia ke Indonesia.'
                            }}
                        </p>
                        <div class="flex items-center gap-3 pt-1">
                            <a
                                :href="whatsappUrl"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-500/15 text-emerald-300 border border-emerald-400/25 hover:bg-emerald-500/25 text-xs font-semibold transition"
                            >
                                <MessageCircle :size="15" />
                                WhatsApp Sales
                            </a>
                            <a
                                :href="settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                                target="_blank"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/5 text-white border border-white/15 hover:bg-white/10 text-xs font-semibold transition"
                            >
                                <Download :size="14" />
                                Road Map PDF
                            </a>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="lg:col-span-2">
                        <h3 class="text-white text-sm font-bold uppercase tracking-wider mb-4">
                            {{ locale === 'en' ? 'Navigation' : 'Navigasi' }}
                        </h3>
                        <ul class="space-y-2.5 text-sm">
                            <li v-for="item in navItems" :key="item.href">
                                <Link :href="item.href" class="hover:text-gold-400 transition-colors">
                                    {{ item.label }}
                                </Link>
                            </li>
                            <li>
                                <Link href="/kontak" class="hover:text-gold-400 transition-colors">
                                    {{ locale === 'en' ? 'Contact & Quote' : 'Kontak & Penawaran' }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Corridors -->
                    <div class="lg:col-span-3">
                        <h3 class="text-white text-sm font-bold uppercase tracking-wider mb-4">
                            {{ locale === 'en' ? 'Active Corridors' : 'Koridor Operasional' }}
                        </h3>
                        <div class="space-y-3 text-sm">
                            <div>
                                <div class="text-xs font-semibold text-gold-400 uppercase mb-1">
                                    {{ locale === 'en' ? 'Origin Countries' : 'Negara Asal' }}
                                </div>
                                <p class="text-slate-400">
                                    {{ locale === 'en' ? 'Japan • China • Taiwan • South Korea • Singapore' : 'Jepang • China • Taiwan • Korea • Singapura' }}
                                </p>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-gold-400 uppercase mb-1">
                                    {{ locale === 'en' ? 'Indonesian Ports' : 'Pelabuhan Tujuan RI' }}
                                </div>
                                <p class="text-slate-400">
                                    Tanjung Priok (Jakarta) • Tanjung Emas (Semarang) • Tanjung Perak (Surabaya)
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Column -->
                    <div class="lg:col-span-3">
                        <h3 class="text-white text-sm font-bold uppercase tracking-wider mb-4">
                            {{ locale === 'en' ? 'Contact Office' : 'Hubungi Kami' }}
                        </h3>
                        <ul class="space-y-3 text-sm text-slate-400">
                            <li class="flex items-start gap-2.5">
                                <MapPin :size="16" class="text-gold-400 shrink-0 mt-0.5" />
                                <div>
                                    <span>{{ settings.contact_address }}</span>
                                    <a
                                        v-if="settings.contact_maps_url"
                                        :href="settings.contact_maps_url"
                                        target="_blank"
                                        rel="noopener"
                                        class="block text-xs font-bold text-gold-400 hover:text-gold-300 mt-1"
                                    >
                                        {{ locale === 'en' ? 'Open in Google Maps →' : 'Buka di Google Maps →' }}
                                    </a>
                                </div>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <Phone :size="16" class="text-gold-400 shrink-0" />
                                <a :href="`tel:${(settings.contact_phone || '02138312253').replace(/[^0-9+]/g, '')}`" class="hover:text-white transition">
                                    {{ settings.contact_phone }}
                                </a>
                            </li>
                            <li v-if="settings.contact_website" class="flex items-center gap-2.5">
                                <Globe :size="16" class="text-gold-400 shrink-0" />
                                <a :href="settings.contact_website" target="_blank" rel="noopener" class="hover:text-white transition">
                                    {{ settings.contact_website.replace(/^https?:\/\//, '').replace(/\/$/, '') }}
                                </a>
                            </li>
                            <li class="flex items-center gap-2.5">
                                <Mail :size="16" class="text-gold-400 shrink-0" />
                                <a :href="`mailto:${settings.contact_email}`" class="hover:text-white transition">
                                    {{ settings.contact_email }}
                                </a>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <Clock :size="16" class="text-gold-400 shrink-0 mt-0.5" />
                                <span>{{ settings.business_hours }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Legal Bar -->
                <div class="mt-12 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                    <p>
                        &copy; {{ new Date().getFullYear() }} {{ settings.company_name || 'PT. CARANO UTAMA LOGISTIK' }}.
                        {{ locale === 'en' ? 'All rights reserved.' : 'Hak cipta dilindungi.' }}
                    </p>
                    <div class="flex items-center gap-5">
                        <Link href="/alur-pengiriman" class="hover:text-slate-300 transition">Road Map Shipment</Link>
                        <Link href="/carano-admin" class="hover:text-gold-400 transition">CMS Portal</Link>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Floating WhatsApp Quick Button -->
        <a
            :href="whatsappUrl"
            target="_blank"
            aria-label="Chat via WhatsApp"
            class="fixed bottom-5 right-5 z-40 inline-flex items-center gap-2 px-4 py-3 rounded-full bg-navy-900 hover:bg-navy-800 text-white shadow-xl border border-gold-400/40 transition-transform hover:-translate-y-0.5"
        >
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse" />
            <MessageCircle :size="18" class="text-gold-400" />
            <span class="hidden sm:inline text-xs font-semibold">
                {{ locale === 'en' ? 'Consult via WA' : 'Konsultasi WA' }}
            </span>
        </a>
    </div>
</template>
