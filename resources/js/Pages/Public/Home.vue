<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import MaritimeParallaxHero from '@/Components/MaritimeParallaxHero.vue';
import PortParallaxDivider from '@/Components/PortParallaxDivider.vue';
import ShipmentRoadmap from '@/Components/ShipmentRoadmap.vue';
import TradeRouteMap from '@/Components/TradeRouteMap.vue';
import FaqAccordion from '@/Components/FaqAccordion.vue';
import CtaBanner from '@/Components/CtaBanner.vue';
import IconMapper from '@/Components/IconMapper.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import CountUpNumber from '@/Components/CountUpNumber.vue';
import {
    AlertTriangle,
    Anchor,
    ArrowRight,
    ArrowUpRight,
    Calendar,
    CheckCircle2,
    ShieldCheck,
    Ship,
} from 'lucide-vue-next';

const props = defineProps({
    sections: { type: Object, default: () => ({}) },
    roadmapSteps: { type: Array, default: () => [] },
    services: { type: Array, default: () => [] },
    tradeHubs: { type: Array, default: () => [] },
    posts: { type: Array, default: () => [] },
    faqs: { type: Array, default: () => [] },
});

const page = usePage();
const locale = computed(() => page.props.locale || 'id');
const settings = computed(() => page.props.settings || {});

const hero = computed(() => props.sections.home_hero || {});
const metrics = computed(() => props.sections.home_metrics || {});
const challenge = computed(() => props.sections.home_challenge || {});
const roadmapIntro = computed(() => props.sections.home_roadmap_intro || {});
const servicesIntro = computed(() => props.sections.home_services_intro || {});
const networkIntro = computed(() => props.sections.home_network_intro || {});
const whyUs = computed(() => props.sections.home_why_us || {});
const cta = computed(() => props.sections.home_cta || {});

const metricItems = computed(() => metrics.value.extra?.items || []);
const challengeCards = computed(() => challenge.value.extra?.cards || []);
const whyPillars = computed(() => whyUs.value.extra?.pillars || []);

// Interactive Problem vs CARANO Solution view toggle
const challengeMode = ref('compare'); // compare, problem, solution

const marqueeTags = computed(() => [
    'JAPAN (TOKYO / OSAKA)',
    'CHINA (SHANGHAI / SHENZHEN)',
    'TAIWAN (KAOHSIUNG / KEELUNG)',
    'SOUTH KOREA (BUSAN / INCHEON)',
    'SINGAPORE (PSA HUB)',
    'TANJUNG PRIOK (JAKARTA)',
    'TANJUNG EMAS (SEMARANG)',
    'TANJUNG PERAK (SURABAYA)',
]);
</script>

<template>
    <Head :title="locale === 'en' ? 'Integrated International Export & Import Logistics' : 'Solusi Logistik Ekspor & Impor Terintegrasi'" />

    <MainLayout>
        <!-- 1. MULTI-LAYER MARITIME PORT & CONTAINER SHIP PARALLAX HERO -->
        <MaritimeParallaxHero :hero="hero" :settings="settings" :locale="locale" />

        <!-- 1B. BRIGHT MARITIME CORRIDOR MARQUEE STRIP -->
        <div class="w-full max-w-full bg-ocean-50 border-b border-slate-200/80 py-3.5 overflow-hidden relative">
            <div class="animate-marquee items-center gap-8">
                <template v-for="repeat in 2" :key="repeat">
                    <div
                        v-for="tag in marqueeTags"
                        :key="`${repeat}-${tag}`"
                        class="inline-flex items-center gap-2.5 px-4 text-xs font-extrabold tracking-widest uppercase text-navy-900 whitespace-nowrap"
                    >
                        <Anchor v-if="tag.includes('TANJUNG')" :size="14" class="text-ocean-600" />
                        <Ship v-else :size="14" class="text-gold-600" />
                        <span>{{ tag }}</span>
                        <span class="w-1.5 h-1.5 rounded-full bg-gold-500/60 ml-3" />
                    </div>
                </template>
            </div>
        </div>

        <!-- 2. BRIGHT ANIMATED COUNT-UP KEY METRICS STRIP -->
        <section class="bg-white py-12 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-5 lg:gap-6">
                    <MotionReveal v-for="(m, idx) in metricItems" :key="idx" :delay="idx * 90">
                        <div class="card-interactive p-6 rounded-2xl bg-ocean-50/70 hover:bg-white border border-slate-200/80 h-full">
                            <div class="w-8 h-1 rounded-full bg-gold-500 mb-3" />
                            <div class="flex items-baseline gap-2">
                                <span class="text-4xl sm:text-5xl font-extrabold text-navy-900">
                                    <CountUpNumber :value="m.value" />
                                </span>
                                <span class="text-sm font-extrabold text-ocean-600">
                                    {{ locale === 'en' ? m.unit_en : m.unit_id }}
                                </span>
                            </div>
                            <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                                {{ locale === 'en' ? m.desc_en : m.desc_id }}
                            </p>
                        </div>
                    </MotionReveal>
                </div>
            </div>
        </section>

        <!-- 3. INTERACTIVE PROBLEM & SOLUTION SECTION (Hacobu Editorial Style) -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <MotionReveal>
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                        <div class="max-w-3xl">
                            <span class="text-xs font-bold tracking-widest uppercase text-gold-600">{{ challenge.badge }}</span>
                            <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                                {{ challenge.title }}
                            </h2>
                            <p class="mt-4 text-slate-600 text-base leading-relaxed">
                                {{ challenge.subtitle }}
                            </p>
                        </div>

                        <!-- Interactive View Mode Switcher -->
                        <div class="inline-flex flex-wrap items-center bg-slate-100 p-1 rounded-2xl sm:rounded-full border border-slate-200 max-w-full self-start">
                            <button
                                type="button"
                                @click="challengeMode = 'compare'"
                                class="px-3 py-1.5 rounded-full text-xs font-bold transition cursor-pointer"
                                :class="challengeMode === 'compare' ? 'bg-navy-900 text-white shadow-xs' : 'text-slate-600'"
                            >
                                {{ locale === 'en' ? 'Compare' : 'Bandingkan' }}
                            </button>
                            <button
                                type="button"
                                @click="challengeMode = 'problem'"
                                class="px-3 py-1.5 rounded-full text-xs font-bold transition cursor-pointer"
                                :class="challengeMode === 'problem' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-600'"
                            >
                                {{ locale === 'en' ? 'Risks' : 'Risiko Impor' }}
                            </button>
                            <button
                                type="button"
                                @click="challengeMode = 'solution'"
                                class="px-3 py-1.5 rounded-full text-xs font-bold transition cursor-pointer"
                                :class="challengeMode === 'solution' ? 'bg-gold-500 text-navy-950 shadow-xs' : 'text-slate-600'"
                            >
                                {{ locale === 'en' ? 'CARANO Way' : 'Solusi CARANO' }}
                            </button>
                        </div>
                    </div>
                </MotionReveal>

                <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <MotionReveal v-for="(card, idx) in challengeCards" :key="idx" :delay="idx * 100">
                        <div class="h-full rounded-3xl border border-slate-200 bg-ocean-50/40 p-7 flex flex-col justify-between hover:border-ocean-500/40 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                            <div>
                                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-slate-200 text-xs font-bold text-navy-800 mb-5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-gold-500" />
                                    {{ locale === 'en' ? card.tag_en : card.tag_id }}
                                </div>

                                <div v-if="challengeMode !== 'solution'" class="mb-5">
                                    <div class="text-[11px] font-bold uppercase tracking-wider text-rose-600 mb-1.5 flex items-center gap-1.5">
                                        <AlertTriangle :size="13" />
                                        {{ locale === 'en' ? 'Industry Challenge' : 'Tantangan Umum' }}
                                    </div>
                                    <p class="text-sm text-slate-600 leading-relaxed">
                                        {{ locale === 'en' ? card.problem_en : card.problem_id }}
                                    </p>
                                </div>
                            </div>

                            <div
                                v-if="challengeMode !== 'problem'"
                                :class="challengeMode === 'compare' ? 'pt-5 border-t border-slate-200/80' : ''"
                            >
                                <div class="text-[11px] font-bold uppercase tracking-wider text-navy-800 mb-1.5 flex items-center gap-1.5">
                                    <ShieldCheck :size="14" class="text-gold-600" />
                                    {{ locale === 'en' ? 'CARANO Solution' : 'Solusi CARANO' }}
                                </div>
                                <p class="text-sm font-semibold text-navy-950 leading-relaxed">
                                    {{ locale === 'en' ? card.solution_en : card.solution_id }}
                                </p>
                            </div>
                        </div>
                    </MotionReveal>
                </div>
            </div>
        </section>

        <!-- 4. INTERACTIVE 10-STEP ROAD MAP SHIPMENT WITH AUTO-PLAY VOYAGE SIMULATOR -->
        <section id="roadmap-section" class="py-20 bg-ocean-50 border-y border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <MotionReveal>
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
                        <div class="max-w-3xl">
                            <span class="text-xs font-bold tracking-widest uppercase text-gold-600">
                                {{ roadmapIntro.badge || 'ROAD MAP SHIPMENT' }}
                            </span>
                            <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                                {{ roadmapIntro.title }}
                            </h2>
                            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                                {{ roadmapIntro.subtitle }}
                            </p>
                        </div>
                        <Link
                            href="/alur-pengiriman"
                            class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 hover:text-gold-600 shrink-0"
                        >
                            <span>{{ locale === 'en' ? 'Full Road Map Page' : 'Buka Halaman Road Map' }}</span>
                            <ArrowRight :size="16" />
                        </Link>
                    </div>
                </MotionReveal>

                <MotionReveal :delay="120">
                    <ShipmentRoadmap
                        :steps="roadmapSteps"
                        :locale="locale"
                        :brochure-url="settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                    />
                </MotionReveal>
            </div>
        </section>

        <!-- 5. CINEMATIC MID-PAGE SCROLL-DRIVEN MARITIME PORT PARALLAX BAND -->
        <PortParallaxDivider :locale="locale" />

        <!-- 6. MODULAR SERVICES SHOWCASE -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <MotionReveal>
                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-12">
                        <div class="max-w-3xl">
                            <span class="text-xs font-bold tracking-widest uppercase text-gold-600">
                                {{ servicesIntro.badge || 'SOLUSI LAYANAN' }}
                            </span>
                            <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                                {{ servicesIntro.title }}
                            </h2>
                            <p class="mt-3 text-slate-600 text-base leading-relaxed">
                                {{ servicesIntro.subtitle }}
                            </p>
                        </div>
                        <Link
                            href="/layanan"
                            class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border border-slate-300 hover:border-navy-900 text-sm font-bold text-navy-900 transition shrink-0"
                        >
                            <span>{{ locale === 'en' ? 'View All & Estimator' : 'Semua Layanan & Simulator' }}</span>
                            <ArrowUpRight :size="16" />
                        </Link>
                    </div>
                </MotionReveal>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <MotionReveal v-for="(service, sIdx) in services" :key="service.id" :delay="sIdx * 90">
                        <div class="card-interactive group h-full rounded-3xl border border-slate-200 bg-white overflow-hidden flex flex-col justify-between">
                            <div>
                                <!-- Sunlit Maritime Illustration Cover -->
                                <div v-if="service.image_path" class="relative h-48 overflow-hidden bg-ocean-100">
                                    <img
                                        :src="service.image_path"
                                        :alt="service.title"
                                        class="w-full h-full object-cover group-hover:scale-105 transition duration-700"
                                    />
                                    <div class="absolute inset-0 bg-gradient-to-t from-navy-950/35 via-transparent to-transparent" />
                                    <span class="absolute top-4 left-4 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/95 text-navy-900 text-[11px] font-bold uppercase tracking-wider shadow-sm">
                                        <IconMapper :name="service.icon" :size="13" class="text-gold-600" />
                                        {{ service.badge }}
                                    </span>
                                </div>

                                <div class="p-7 sm:p-8">
                                    <div v-if="!service.image_path" class="flex items-center justify-between gap-4 mb-5">
                                        <div class="w-12 h-12 rounded-2xl bg-ocean-50 text-navy-800 flex items-center justify-center">
                                            <IconMapper :name="service.icon" :size="24" />
                                        </div>
                                        <span class="px-3 py-1 rounded-full bg-gold-50 text-gold-600 border border-gold-500/20 text-[11px] font-bold uppercase tracking-wider">
                                            {{ service.badge }}
                                        </span>
                                    </div>

                                    <h3 class="text-xl sm:text-2xl font-extrabold text-navy-950 group-hover:text-ocean-600 transition-colors">
                                        {{ service.title }}
                                    </h3>
                                    <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                                        {{ service.short_desc }}
                                    </p>

                                    <ul v-if="service.features && service.features.length" class="mt-5 space-y-2">
                                        <li
                                            v-for="(feat, fIdx) in service.features"
                                            :key="fIdx"
                                            class="flex items-start gap-2 text-sm text-slate-700"
                                        >
                                            <CheckCircle2 :size="16" class="text-gold-600 shrink-0 mt-0.5" />
                                            <span>{{ feat }}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="px-7 sm:px-8 pb-7 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <Link
                                    :href="`/layanan/${service.slug}`"
                                    class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 group-hover:text-gold-600 transition"
                                >
                                    <span>{{ locale === 'en' ? 'Explore Service Details' : 'Pelajari Detail Layanan' }}</span>
                                    <ArrowRight :size="16" class="transition-transform group-hover:translate-x-1" />
                                </Link>
                            </div>
                        </div>
                    </MotionReveal>
                </div>
            </div>
        </section>

        <!-- 7. INTERACTIVE MARITIME TRADE CORRIDOR MAP -->
        <section class="py-20 bg-ocean-50 border-y border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <MotionReveal>
                    <div class="max-w-3xl mb-10">
                        <span class="text-xs font-bold tracking-widest uppercase text-gold-600">
                            {{ networkIntro.badge || 'JARINGAN RUTE' }}
                        </span>
                        <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                            {{ networkIntro.title }}
                        </h2>
                        <p class="mt-3 text-slate-600 text-base leading-relaxed">
                            {{ networkIntro.subtitle }}
                        </p>
                    </div>
                </MotionReveal>

                <MotionReveal :delay="120">
                    <TradeRouteMap :hubs="tradeHubs" :locale="locale" />
                </MotionReveal>
            </div>
        </section>

        <!-- 8. WHY PT. CARANO UTAMA LOGISTIK -->
        <section class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                    <MotionReveal class="lg:col-span-5">
                        <span class="text-xs font-bold tracking-widest uppercase text-gold-600">{{ whyUs.badge }}</span>
                        <h2 class="mt-2 text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                            {{ whyUs.title }}
                        </h2>
                        <p class="mt-4 text-slate-600 leading-relaxed">
                            {{ whyUs.subtitle }}
                        </p>
                        <Link
                            href="/tentang-kami"
                            class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-navy-900 hover:text-gold-600 transition"
                        >
                            <span>{{ locale === 'en' ? 'About PT. CARANO UTAMA LOGISTIK' : 'Kenali PT. CARANO UTAMA LOGISTIK' }}</span>
                            <ArrowRight :size="16" />
                        </Link>
                    </MotionReveal>

                    <div class="lg:col-span-7 grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <MotionReveal v-for="(p, idx) in whyPillars" :key="idx" :delay="idx * 90">
                            <div class="h-full p-6 rounded-2xl border border-slate-200 bg-ocean-50/40 hover:bg-white hover:shadow-lg hover:-translate-y-0.5 transition-all">
                                <div class="w-9 h-9 rounded-xl bg-navy-900 text-gold-400 font-extrabold text-sm flex items-center justify-center mb-4">
                                    0{{ idx + 1 }}
                                </div>
                                <h3 class="text-base font-extrabold text-navy-950">
                                    {{ locale === 'en' ? p.title_en : p.title_id }}
                                </h3>
                                <p class="mt-2 text-sm text-slate-600 leading-relaxed">
                                    {{ locale === 'en' ? p.desc_en : p.desc_id }}
                                </p>
                            </div>
                        </MotionReveal>
                    </div>
                </div>
            </div>
        </section>

        <!-- 9. INSIGHTS & FAQ -->
        <section class="py-20 bg-ocean-50 border-t border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
                <div v-if="posts.length">
                    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
                        <div>
                            <span class="text-xs font-bold tracking-widest uppercase text-gold-600">
                                {{ locale === 'en' ? 'KNOWLEDGE HUB' : 'INSIGHT & EDUKASI EKSPOR-IMPOR' }}
                            </span>
                            <h2 class="mt-2 text-3xl font-extrabold text-navy-950">
                                {{ locale === 'en' ? 'Latest Logistics Insights' : 'Artikel & Panduan Terbaru' }}
                            </h2>
                        </div>
                        <Link href="/insight" class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 hover:text-gold-600">
                            <span>{{ locale === 'en' ? 'All Articles' : 'Semua Artikel' }}</span>
                            <ArrowRight :size="16" />
                        </Link>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <MotionReveal v-for="(post, idx) in posts" :key="post.id" :delay="idx * 90">
                            <Link
                                :href="`/insight/${post.slug}`"
                                class="group h-full bg-white rounded-3xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col justify-between"
                            >
                                <div>
                                    <div class="h-44 bg-gradient-to-br from-navy-900 to-ocean-600 relative overflow-hidden flex items-center justify-center">
                                        <img
                                            v-if="post.featured_image"
                                            :src="post.featured_image"
                                            :alt="post.title"
                                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                                        />
                                        <img
                                            v-else
                                            :src="settings.logo_mark || '/images/brand/logo-carano-mark.png'"
                                            alt="Carano"
                                            class="h-16 w-16 opacity-35"
                                        />
                                        <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-white/95 text-navy-900 text-[11px] font-bold">
                                            {{ post.category }}
                                        </span>
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
                                            <Calendar :size="13" />
                                            <span>{{ post.published_at }}</span>
                                        </div>
                                        <h3 class="text-lg font-extrabold text-navy-950 group-hover:text-ocean-600 transition line-clamp-2">
                                            {{ post.title }}
                                        </h3>
                                        <p class="mt-2.5 text-sm text-slate-600 line-clamp-3 leading-relaxed">
                                            {{ post.excerpt }}
                                        </p>
                                    </div>
                                </div>
                                <div class="px-6 pb-6 pt-2 text-xs font-bold text-navy-900 group-hover:text-gold-600 inline-flex items-center gap-1">
                                    {{ locale === 'en' ? 'Read Article' : 'Baca Selengkapnya' }}
                                    <ArrowRight :size="14" />
                                </div>
                            </Link>
                        </MotionReveal>
                    </div>
                </div>

                <div v-if="faqs.length" class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    <div class="lg:col-span-4">
                        <span class="text-xs font-bold tracking-widest uppercase text-gold-600">FAQ</span>
                        <h2 class="mt-2 text-3xl font-extrabold text-navy-950">
                            {{ locale === 'en' ? 'Frequently Asked Questions' : 'Pertanyaan yang Sering Diajukan' }}
                        </h2>
                        <p class="mt-3 text-sm text-slate-600 leading-relaxed">
                            {{
                                locale === 'en'
                                    ? 'Quick answers about our import routes, documentation, customs brokerage, and delivery options.'
                                    : 'Jawaban ringkas mengenai rute impor, dokumen, bea cukai, dan pengiriman bersama PT. CARANO UTAMA LOGISTIK.'
                            }}
                        </p>
                    </div>
                    <div class="lg:col-span-8">
                        <FaqAccordion :faqs="faqs" />
                    </div>
                </div>
            </div>
        </section>

        <!-- 10. PRE-FOOTER CTA -->
        <CtaBanner :section="cta" :locale="locale" />
    </MainLayout>
</template>
