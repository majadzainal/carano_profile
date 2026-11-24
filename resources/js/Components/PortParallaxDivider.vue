<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight, Plane, Ship, Truck } from 'lucide-vue-next';

const props = defineProps({
    locale: { type: String, default: 'id' },
});

const sectionEl = ref(null);
const progress = ref(0.5);
const activeMode = ref('sea');

const modes = computed(() => [
    {
        key: 'sea',
        icon: Ship,
        image: '/images/illustrations/sea-freight-vessel.jpg',
        title: 'Sea Freight (FCL & LCL)',
        desc:
            props.locale === 'en'
                ? 'Core ocean container corridors connecting Japan, China, Taiwan, South Korea & Singapore directly to Tanjung Priok, Tanjung Emas, and Tanjung Perak.'
                : 'Koridor utama kapal kontainer yang menghubungkan Jepang, China, Taiwan, Korea & Singapura langsung ke Tanjung Priok, Tanjung Emas, dan Tanjung Perak.',
    },
    {
        key: 'land',
        icon: Truck,
        image: '/images/illustrations/port-customs-terminal.jpg',
        title: props.locale === 'en' ? 'Origin & Domestic Trucking' : 'Strapping, Stripping & Trucking',
        desc:
            props.locale === 'en'
                ? 'Export-standard strapping at overseas factories through supervised stripping and nationwide last-mile warehouse delivery.'
                : 'Pengamanan strapping di pabrik negara asal hingga proses stripping terawasi dan pengiriman armada truk ke gudang tujuan Anda.',
    },
    {
        key: 'air',
        icon: Plane,
        image: '/images/illustrations/warehouse-export-strapping.jpg',
        title: 'Air Freight Support',
        desc:
            props.locale === 'en'
                ? 'Priority air cargo uplift for time-critical spare parts, samples, and high-value industrial shipments.'
                : 'Dukungan kargo udara prioritas untuk suku cadang mendesak, sampel produksi, dan komoditas bernilai tinggi.',
    },
]);

const currentMode = computed(() => modes.value.find((m) => m.key === activeMode.value) || modes.value[0]);

let raf = null;
const updateScroll = () => {
    if (!sectionEl.value) return;
    const rect = sectionEl.value.getBoundingClientRect();
    const vh = window.innerHeight || 800;
    const raw = (vh - rect.top) / (vh + rect.height);
    progress.value = Math.max(0, Math.min(1, raw));
};

const onScroll = () => {
    if (raf) return;
    raf = requestAnimationFrame(() => {
        updateScroll();
        raf = null;
    });
};

onMounted(() => {
    updateScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
});
onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    if (raf) cancelAnimationFrame(raf);
});

const bgTranslateY = computed(() => (progress.value - 0.5) * -90);
</script>

<template>
    <!-- BRIGHT SUNLIT PHOTO PARALLAX MARITIME SHOWCASE -->
    <section
        ref="sectionEl"
        class="relative py-20 sm:py-24 overflow-hidden bg-ocean-50 border-y border-slate-200"
    >
        <!-- True Scroll-Driven Parallax Sunlit Maritime Photo -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <img
                :src="currentMode.image"
                :alt="currentMode.title"
                class="w-full h-[130%] -top-[15%] relative object-cover object-center transition-all duration-500 will-change-transform"
                :style="{ transform: `translate3d(0, ${bgTranslateY}px, 0)` }"
            />
            <!-- Clean translucent daylight veil so content pops brightly -->
            <div class="absolute inset-0 bg-gradient-to-r from-white/92 via-white/75 to-navy-900/35" />
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-6">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white border border-slate-200 text-gold-600 text-xs font-extrabold uppercase tracking-wider shadow-2xs mb-4">
                        {{ locale === 'en' ? 'MULTIMODAL PORT SYNERGY' : 'SINERGI PELABUHAN & MULTIMODA' }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                        {{
                            locale === 'en'
                                ? 'Every Vessel, Container & Port Handled With Precision.'
                                : 'Setiap Kapal, Kontainer & Pelabuhan Ditangani Secara Presisi.'
                        }}
                    </h2>
                    <p class="mt-4 text-slate-700 leading-relaxed font-medium">
                        {{
                            locale === 'en'
                                ? 'Switch transport modes to preview how our sea freight, port terminal handling, and inland fleets work together seamlessly.'
                                : 'Pilih moda transportasi di samping untuk melihat integrasi kapal kontainer, penanganan pelabuhan, dan armada distribusi PT. CARANO UTAMA LOGISTIK.'
                        }}
                    </p>
                </div>

                <div class="lg:col-span-6 bg-white/95 backdrop-blur-xl border border-slate-200 rounded-3xl p-6 sm:p-7 shadow-xl">
                    <div class="grid grid-cols-3 gap-2 mb-5">
                        <button
                            v-for="m in modes"
                            :key="m.key"
                            type="button"
                            @click="activeMode = m.key"
                            class="flex flex-col items-center justify-center gap-1.5 py-3 px-2 rounded-2xl text-xs font-bold border transition cursor-pointer"
                            :class="
                                activeMode === m.key
                                    ? 'bg-navy-900 text-gold-400 border-navy-900 shadow-md'
                                    : 'bg-ocean-50 text-navy-900 border-slate-200 hover:border-gold-500'
                            "
                        >
                            <component :is="m.icon" :size="20" />
                            <span class="truncate max-w-full">{{ m.key === 'sea' ? 'Sea Freight' : m.key === 'land' ? 'Trucking' : 'Air Freight' }}</span>
                        </button>
                    </div>

                    <div class="p-5 rounded-2xl bg-ocean-50/80 border border-slate-200/80">
                        <h3 class="text-lg font-extrabold text-navy-950">{{ currentMode.title }}</h3>
                        <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ currentMode.desc }}</p>
                        <Link
                            href="/layanan"
                            class="mt-4 inline-flex items-center gap-1.5 text-xs font-extrabold text-ocean-600 hover:text-gold-600 transition"
                        >
                            <span>{{ locale === 'en' ? 'Open Interactive Service Estimator' : 'Buka Simulator & Detail Layanan' }}</span>
                            <ArrowUpRight :size="15" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
