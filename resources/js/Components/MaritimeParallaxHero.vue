<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import LottiePlayer from '@/Components/LottiePlayer.vue';
import portRadarAnim from '@/assets/lottie/port-radar.json';
import {
    Anchor,
    ArrowDown,
    ArrowRight,
    ArrowUpRight,
    Download,
    Plane,
    Ship,
    Truck,
} from 'lucide-vue-next';

const props = defineProps({
    hero: { type: Object, default: () => ({}) },
    settings: { type: Object, default: () => ({}) },
    locale: { type: String, default: 'id' },
});

const scrollY = ref(0);
const mouseX = ref(0);
const selectedPortKey = ref('priok');

const ports = computed(() => [
    {
        key: 'priok',
        name: 'Tanjung Priok',
        city: 'Jakarta',
        code: 'IDJKT',
        eta: props.locale === 'en' ? '7–14 Days Ocean Transit' : '7–14 Hari Pelayaran',
        origins: props.locale === 'en' ? 'Japan, China, Taiwan, Korea, Singapore' : 'Jepang, China, Taiwan, Korea, Singapura',
        status: props.locale === 'en' ? 'Direct FCL / LCL Gateway' : 'Gerbang Utama FCL / LCL',
    },
    {
        key: 'emas',
        name: 'Tanjung Emas',
        city: 'Semarang',
        code: 'IDSRG',
        eta: props.locale === 'en' ? '9–16 Days Ocean Transit' : '9–16 Hari Pelayaran',
        origins: props.locale === 'en' ? 'Central Java Industrial Corridor' : 'Koridor Industri Jawa Tengah',
        status: props.locale === 'en' ? 'Customs & Stripping Ready' : 'Siap Bea Cukai & Stripping',
    },
    {
        key: 'perak',
        name: 'Tanjung Perak',
        city: 'Surabaya',
        code: 'IDSUB',
        eta: props.locale === 'en' ? '8–15 Days Ocean Transit' : '8–15 Hari Pelayaran',
        origins: props.locale === 'en' ? 'East Java & Eastern Indonesia Hub' : 'Hub Jawa Timur & Indonesia Timur',
        status: props.locale === 'en' ? 'Full Container & Trucking Hub' : 'Hub Kontainer & Trucking',
    },
]);

const activePort = computed(() => ports.value.find((p) => p.key === selectedPortKey.value) || ports.value[0]);

let raf = null;
const handleScroll = () => {
    if (raf) return;
    raf = requestAnimationFrame(() => {
        scrollY.value = Math.min(window.scrollY, 900);
        raf = null;
    });
};

const handleMouseMove = (e) => {
    if (window.innerWidth < 1024) {
        mouseX.value = 0;
        return;
    }
    const cx = window.innerWidth / 2;
    mouseX.value = (e.clientX - cx) / cx;
};

onMounted(() => {
    window.addEventListener('scroll', handleScroll, { passive: true });
    window.addEventListener('mousemove', handleMouseMove, { passive: true });
});
onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll);
    window.removeEventListener('mousemove', handleMouseMove);
    if (raf) cancelAnimationFrame(raf);
});

const bgPhotoStyle = computed(() => ({
    transform: `translate3d(${mouseX.value * -10}px, ${scrollY.value * 0.28}px, 0) scale(1.08)`,
}));

const photoCardStyle = computed(() => ({
    transform: `translate3d(${mouseX.value * 8}px, ${scrollY.value * -0.06}px, 0)`,
}));
</script>

<template>
    <!-- BRIGHT, SUNLIT HACOBU-STYLE MARITIME PARALLAX HERO -->
    <section class="relative overflow-hidden bg-white border-b border-slate-200/80">
        <!-- Parallax Sunlit Seaport Background Photo with Airy Daylight Gradient -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <img
                src="/images/illustrations/hero-port-maritime.jpg"
                alt="Pelabuhan Kontainer Internasional"
                class="w-full h-full object-cover object-center opacity-25 will-change-transform"
                :style="bgPhotoStyle"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-white via-white/92 to-white/55" />
            <div class="absolute inset-0 bg-gradient-to-b from-white/50 via-transparent to-ocean-50/90" />
        </div>

        <!-- Subtle Animated Maritime Shipping Arc Overlay -->
        <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-45" viewBox="0 0 1440 700" preserveAspectRatio="none" fill="none">
            <path d="M -40 580 Q 480 410 920 480 T 1500 220" stroke="#E6A92E" stroke-width="2" class="animate-route-dash" />
            <path d="M -20 620 Q 520 490 980 540 T 1500 310" stroke="#2A67B1" stroke-opacity="0.45" stroke-width="1.5" class="animate-route-dash" />
        </svg>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-16 sm:pt-16 sm:pb-24">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
                <!-- Left Editorial Headline (Crisp Royal Navy on Bright Surface) -->
                <div class="lg:col-span-7 min-w-0">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/95 border border-slate-200 shadow-2xs text-navy-900 text-[11px] sm:text-xs font-bold tracking-wider uppercase mb-5 max-w-full">
                        <span class="w-2 h-2 rounded-full bg-gold-500 animate-pulse shrink-0" />
                        <span class="leading-snug">{{ hero.badge || 'INTERNATIONAL FREIGHT FORWARDER COMPANY' }}</span>
                    </div>

                    <h1 class="text-[1.85rem] sm:text-5xl lg:text-[3.35rem] font-extrabold text-navy-950 leading-[1.15] sm:leading-[1.12] tracking-tight break-words">
                        {{ hero.title }}
                    </h1>

                    <p class="mt-5 text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                        {{ hero.subtitle }}
                    </p>

                    <!-- Dual CTAs -->
                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        <Link
                            :href="hero.cta_url || '/kontak'"
                            class="btn-gold-sheen group inline-flex items-center gap-2 px-7 py-4 rounded-full bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-lg shadow-gold-500/25 hover:-translate-y-0.5"
                        >
                            <span>{{ hero.cta_label || (locale === 'en' ? 'Request a Quote' : 'Konsultasi Pengiriman') }}</span>
                            <ArrowUpRight :size="18" class="transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
                        </Link>

                        <a
                            :href="hero.secondary_cta_url || settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                            target="_blank"
                            class="inline-flex items-center gap-2 px-6 py-4 rounded-full bg-white hover:bg-ocean-50 text-navy-900 font-bold text-sm border border-slate-300 shadow-2xs transition"
                        >
                            <Download :size="17" class="text-ocean-600" />
                            <span>{{ hero.secondary_cta_label || 'Road Map PDF' }}</span>
                        </a>
                    </div>

                    <!-- Multimodal Badges matching New Logo Carano -->
                    <div class="mt-9 pt-7 border-t border-slate-200/90 flex flex-wrap items-center gap-5 text-xs font-bold text-navy-900">
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-slate-200">
                            <Ship :size="15" class="text-ocean-600" />
                            Sea Freight (FCL / LCL)
                        </span>
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-slate-200">
                            <Truck :size="15" class="text-ocean-600" />
                            Strapping, Stripping & Trucking
                        </span>
                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/90 border border-slate-200">
                            <Plane :size="15" class="text-ocean-600" />
                            Air Freight Support
                        </span>
                    </div>
                </div>

                <!-- Right Visual Showcase: Sunlit Port Photo Card + Interactive Port Gateway Selector -->
                <div class="lg:col-span-5 min-w-0 will-change-transform" :style="photoCardStyle">
                    <div class="rounded-[2rem] bg-white/95 backdrop-blur-xl border border-slate-200/90 shadow-[0_24px_60px_rgba(10,42,102,0.12)] overflow-hidden">
                        <!-- Sunlit Maritime Port Photograph with Live Animated Vessel Badge -->
                        <div class="relative h-56 sm:h-60 overflow-hidden bg-ocean-100">
                            <img
                                src="/images/illustrations/hero-port-maritime.jpg"
                                alt="Kapal Kontainer & Pelabuhan PT. CARANO UTAMA LOGISTIK"
                                class="w-full h-full object-cover scale-105 hover:scale-110 transition duration-700"
                            />
                            <div class="absolute inset-0 bg-gradient-to-t from-navy-950/65 via-navy-950/10 to-transparent" />

                            <!-- Top Floating Official Logo Mark Pill -->
                            <div class="absolute top-4 left-4 inline-flex items-center gap-2.5 px-3 py-1.5 rounded-2xl bg-white/95 backdrop-blur-md shadow-md">
                                <img
                                    :src="settings.logo_mark || '/images/brand/logo-carano-mark.png'"
                                    alt="Carano"
                                    class="h-7 w-7 object-contain"
                                />
                                <div class="leading-tight">
                                    <div class="text-[10px] font-extrabold text-navy-950">CARANO CORRIDOR</div>
                                    <div class="text-[9px] font-bold text-gold-600 uppercase">East Asia → Indonesia</div>
                                </div>
                            </div>

                            <span class="absolute top-4 right-4 inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/95 text-emerald-700 text-[11px] font-bold shadow-sm">
                                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse" />
                                Active Route
                            </span>

                            <!-- Bottom Overlay Caption -->
                            <div class="absolute bottom-3.5 left-4 right-4 flex items-center justify-between text-white">
                                <div>
                                    <div class="text-[10px] font-bold uppercase tracking-widest text-gold-400">10-Step Road Map Standard</div>
                                    <div class="text-sm font-extrabold">Japan • China • Taiwan • Korea • Singapore</div>
                                </div>
                            </div>
                        </div>

                        <!-- Interactive Indonesian Port Switcher (Light & Crisp) -->
                        <div class="p-5 sm:p-6 space-y-4">
                            <div>
                                <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                                    {{ locale === 'en' ? 'Select Indonesian Destination Port:' : 'Pilih Pelabuhan Tujuan Indonesia:' }}
                                </div>
                                <div class="grid grid-cols-3 gap-2">
                                    <button
                                        v-for="p in ports"
                                        :key="p.key"
                                        type="button"
                                        @click="selectedPortKey = p.key"
                                        class="px-2.5 py-2 rounded-xl text-left border transition cursor-pointer"
                                        :class="
                                            selectedPortKey === p.key
                                                ? 'bg-navy-900 text-white border-navy-900 shadow-sm'
                                                : 'bg-ocean-50/70 text-navy-900 border-slate-200 hover:border-gold-500'
                                        "
                                    >
                                        <div class="text-[10px] font-mono font-bold" :class="selectedPortKey === p.key ? 'text-gold-400' : 'text-ocean-600'">
                                            {{ p.code }}
                                        </div>
                                        <div class="text-xs font-extrabold truncate">{{ p.name.replace('Tanjung ', 'Tj. ') }}</div>
                                    </button>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-ocean-50 border border-slate-200/80 space-y-2">
                                <div class="flex flex-wrap items-center justify-between gap-2">
                                    <span class="inline-flex items-center gap-2 text-sm font-extrabold text-navy-950">
                                        <LottiePlayer :animation-data="portRadarAnim" class="w-7 h-7 shrink-0" />
                                        Pelabuhan {{ activePort.name }}
                                    </span>
                                    <span class="text-xs font-bold text-ocean-600">{{ activePort.city }}</span>
                                </div>
                                <div class="grid grid-cols-2 gap-2 pt-2 border-t border-slate-200/80 text-xs">
                                    <div>
                                        <div class="text-[10px] uppercase text-slate-500">{{ locale === 'en' ? 'Est. Transit' : 'Estimasi Laut' }}</div>
                                        <div class="font-extrabold text-navy-900 mt-0.5">{{ activePort.eta }}</div>
                                    </div>
                                    <div>
                                        <div class="text-[10px] uppercase text-slate-500">{{ locale === 'en' ? 'Status' : 'Layanan' }}</div>
                                        <div class="font-bold text-ocean-600 mt-0.5">{{ activePort.status }}</div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-wrap items-center justify-between gap-2 pt-1">
                                <Link
                                    :href="`/kontak?destination=${encodeURIComponent('Pelabuhan ' + activePort.name)}`"
                                    class="inline-flex items-center gap-1.5 text-xs font-extrabold text-navy-900 hover:text-gold-600 transition"
                                >
                                    <span>{{ locale === 'en' ? `Quote for ${activePort.name}` : `Hitung Estimasi ke ${activePort.name}` }}</span>
                                    <ArrowRight :size="14" />
                                </Link>
                                <a href="#roadmap-section" class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-400 hover:text-navy-900 transition">
                                    <span>Road Map</span>
                                    <ArrowDown :size="13" class="animate-bounce" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
