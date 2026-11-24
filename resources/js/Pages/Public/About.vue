<script setup>
import { computed, ref } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import CtaBanner from '@/Components/CtaBanner.vue';
import { CheckCircle2, Compass, Globe, Plane, Ship, Sparkles, Target, Truck } from 'lucide-vue-next';

const props = defineProps({
    story: { type: Object, default: () => ({}) },
    whyUs: { type: Object, default: () => ({}) },
    metrics: { type: Object, default: () => ({}) },
    cta: { type: Object, default: () => ({}) },
});

const page = usePage();
const locale = computed(() => page.props.locale || 'id');
const settings = computed(() => page.props.settings || {});

const vision = computed(() =>
    locale.value === 'en' ? props.story?.extra?.vision_en : props.story?.extra?.vision_id
);
const missions = computed(() =>
    (locale.value === 'en' ? props.story?.extra?.missions_en : props.story?.extra?.missions_id) || []
);
const pillars = computed(() => props.whyUs?.extra?.pillars || []);

// Interactive Brand Emblem Philosophy Explorer
const selectedSymbol = ref('carano');
const symbols = computed(() => [
    {
        key: 'carano',
        icon: Sparkles,
        title: locale.value === 'en' ? 'Golden Carano Chalice' : 'Wadah Carano Emas',
        desc:
            locale.value === 'en'
                ? 'A heritage symbol of honor, warm welcome, and sincere stewardship—representing our commitment to safeguard every shipment with integrity.'
                : 'Simbol budaya Nusantara yang melambangkan penghormatan, amanah, dan ketulusan pelayanan dalam menjaga setiap kargo klien.',
    },
    {
        key: 'globe',
        icon: Globe,
        title: locale.value === 'en' ? 'Global Trade Sphere' : 'Bola Dunia (Perdagangan Global)',
        desc:
            locale.value === 'en'
                ? 'Reflects our cross-border reach linking industrial suppliers across Japan, China, Taiwan, South Korea, and Singapore with Indonesia.'
                : 'Mewakili jangkauan perdagangan lintas negara yang menghubungkan pabrik di Jepang, China, Taiwan, Korea, dan Singapura ke Indonesia.',
    },
    {
        key: 'sea',
        icon: Ship,
        title: locale.value === 'en' ? 'Ocean Container Vessel' : 'Kapal Kontainer Maritim',
        desc:
            locale.value === 'en'
                ? 'Our core maritime backbone connecting international loading ports directly into Tanjung Priok, Tanjung Emas, and Tanjung Perak.'
                : 'Tulang punggung pengiriman laut FCL/LCL menuju 3 pelabuhan gerbang utama Indonesia: Tanjung Priok, Tanjung Emas, dan Tanjung Perak.',
    },
    {
        key: 'multimodal',
        icon: Truck,
        title: locale.value === 'en' ? 'Inland Trucking & Air Freight' : 'Armada Darat & Kargo Udara',
        desc:
            locale.value === 'en'
                ? 'Completes the end-to-end chain via origin strapping, domestic stripping/delivery fleets, and priority air freight when speed is critical.'
                : 'Melengkapi rantai end-to-end melalui strapping & trucking pabrik asal, stripping/delivery domestik, serta kargo udara prioritas.',
    },
]);

const activeSymbol = computed(() => symbols.value.find((s) => s.key === selectedSymbol.value) || symbols.value[0]);
</script>

<template>
    <Head :title="locale === 'en' ? 'About Us' : 'Tentang Kami'" />

    <MainLayout>
        <PageParallaxHero
            :badge="story?.badge || 'PT. CARANO UTAMA LOGISTIK'"
            :title="story?.title || 'Tentang PT. CARANO UTAMA LOGISTIK'"
            :subtitle="story?.subtitle"
            image="/images/illustrations/warehouse-export-strapping.jpg"
        />

        <!-- Interactive Official Seal Philosophy Explorer (Bright & Airy) -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <MotionReveal class="lg:col-span-7 space-y-8">
                    <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-md">
                        <img
                            src="/images/illustrations/hero-port-maritime.jpg"
                            alt="Operasional Maritim PT. CARANO UTAMA LOGISTIK"
                            class="w-full h-64 sm:h-72 object-cover"
                        />
                    </div>
                    <div class="prose-carano" v-html="story?.body" />
                </MotionReveal>

                <MotionReveal class="lg:col-span-5 space-y-6" :delay="120">
                    <!-- Bright Interactive Logo Philosophy Card -->
                    <div class="p-6 sm:p-7 rounded-3xl bg-ocean-50 border border-slate-200 shadow-sm">
                        <div class="flex flex-col items-center text-center">
                            <img
                                :src="settings.logo_light || '/images/brand/logo-carano-light.png'"
                                :alt="settings.company_name"
                                class="h-44 w-44 object-contain"
                            />
                            <div class="mt-3 text-[11px] font-bold uppercase tracking-widest text-gold-600">
                                {{ locale === 'en' ? 'Click Emblem Elements to Explore Philosophy' : 'Klik Elemen Logo Resmi untuk Melihat Filosofi' }}
                            </div>
                        </div>

                        <div class="mt-4 grid grid-cols-2 gap-2">
                            <button
                                v-for="sym in symbols"
                                :key="sym.key"
                                type="button"
                                @click="selectedSymbol = sym.key"
                                class="flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-bold border transition cursor-pointer"
                                :class="
                                    selectedSymbol === sym.key
                                        ? 'bg-navy-900 text-gold-400 border-navy-900 shadow-xs'
                                        : 'bg-white text-navy-900 border-slate-200 hover:border-gold-500'
                                "
                            >
                                <component :is="sym.icon" :size="14" />
                                <span class="truncate">{{ sym.title }}</span>
                            </button>
                        </div>

                        <div class="mt-4 p-4 rounded-2xl bg-white border border-slate-200">
                            <div class="text-sm font-extrabold text-navy-950">{{ activeSymbol.title }}</div>
                            <p class="mt-1.5 text-xs text-slate-600 leading-relaxed">{{ activeSymbol.desc }}</p>
                        </div>
                    </div>

                    <div class="p-7 rounded-3xl bg-gold-50 border border-gold-500/30">
                        <div class="flex items-center gap-2 text-navy-900 text-xs font-bold uppercase tracking-wider mb-3">
                            <Compass :size="16" class="text-gold-600" />
                            <span>{{ locale === 'en' ? 'Our Vision' : 'Visi Perusahaan' }}</span>
                        </div>
                        <p class="text-base font-semibold leading-relaxed text-navy-950">
                            {{ vision }}
                        </p>
                    </div>

                    <div class="p-7 rounded-3xl bg-white border border-slate-200 shadow-xs">
                        <div class="flex items-center gap-2 text-navy-900 text-xs font-bold uppercase tracking-wider mb-4">
                            <Target :size="16" class="text-gold-600" />
                            <span>{{ locale === 'en' ? 'Our Mission' : 'Misi Perusahaan' }}</span>
                        </div>
                        <ul class="space-y-3">
                            <li v-for="(m, i) in missions" :key="i" class="flex items-start gap-2.5 text-sm text-slate-700 leading-relaxed">
                                <CheckCircle2 :size="17" class="text-gold-600 shrink-0 mt-0.5" />
                                <span>{{ m }}</span>
                            </li>
                        </ul>
                    </div>
                </MotionReveal>
            </div>
        </section>

        <!-- Why Us Pillars -->
        <section v-if="pillars.length" class="py-16 bg-ocean-50 border-t border-slate-200/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <MotionReveal>
                    <h2 class="text-3xl font-extrabold text-navy-950 mb-8">{{ whyUs?.title }}</h2>
                </MotionReveal>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <MotionReveal v-for="(p, i) in pillars" :key="i" :delay="i * 80">
                        <div class="h-full p-6 rounded-2xl bg-white border border-slate-200 hover:shadow-lg hover:-translate-y-0.5 transition">
                            <div class="text-2xl font-extrabold text-gold-500 mb-3">0{{ i + 1 }}</div>
                            <h3 class="text-base font-extrabold text-navy-950">{{ locale === 'en' ? p.title_en : p.title_id }}</h3>
                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ locale === 'en' ? p.desc_en : p.desc_id }}</p>
                        </div>
                    </MotionReveal>
                </div>
            </div>
        </section>

        <CtaBanner :section="cta" :locale="locale" />
    </MainLayout>
</template>
