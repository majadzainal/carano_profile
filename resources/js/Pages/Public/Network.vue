<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import TradeRouteMap from '@/Components/TradeRouteMap.vue';
import CtaBanner from '@/Components/CtaBanner.vue';
import { Anchor, ArrowRight, ArrowUpRight, Compass, Factory } from 'lucide-vue-next';

const props = defineProps({
    intro: { type: Object, default: () => ({}) },
    tradeHubs: { type: Array, default: () => [] },
    cta: { type: Object, default: () => ({}) },
});

const locale = computed(() => usePage().props.locale || 'id');
const origins = computed(() => props.tradeHubs.filter((h) => h.type === 'origin'));
const destinations = computed(() => props.tradeHubs.filter((h) => h.type === 'destination'));

// Interactive Two-Way Corridor Pairing Tool (Import & Export)
const pairDirection = ref('Impor');
const pairOrigin = ref(origins.value[0]?.name || 'Jepang');
const pairDest = ref(destinations.value[0]?.name || 'Pelabuhan Tanjung Priok');

const pairTransit = computed(() => {
    const base = { Jepang: 11, China: 10, Taiwan: 9, 'Korea Selatan': 12, Singapura: 4, Japan: 11, 'South Korea': 12, Singapore: 4 };
    const d = base[pairOrigin.value] || 10;
    const extra = pairDest.value.includes('Priok') ? 0 : 2;
    return `${d + extra}–${d + extra + 4} ${locale.value === 'en' ? 'Days' : 'Hari'}`;
});

const pairLabel = computed(() =>
    pairDirection.value === 'Ekspor'
        ? `${pairDest.value} → ${pairOrigin.value}`
        : `${pairOrigin.value} → ${pairDest.value}`
);
</script>

<template>
    <Head :title="locale === 'en' ? 'Trade Corridor Network' : 'Jaringan Rute & Pelabuhan'" />

    <MainLayout>
        <PageParallaxHero
            :badge="intro?.badge || 'JARINGAN RUTE'"
            :title="intro?.title || 'Jaringan Koridor Asia Timur – Indonesia'"
            :subtitle="intro?.subtitle"
            image="/images/illustrations/port-customs-terminal.jpg"
        />

        <section class="py-16 bg-ocean-50/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-14">
                <!-- Interactive Corridor Pairing Simulator -->
                <MotionReveal>
                <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <div class="flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-gold-600">
                            <Compass :size="16" />
                            <span>{{ locale === 'en' ? 'Interactive Two-Way Corridor Selector' : 'Simulasi Rute Ekspor & Impor' }}</span>
                        </div>
                        <div class="inline-flex items-center bg-slate-100 p-1 rounded-full border border-slate-200">
                            <button
                                type="button"
                                @click="pairDirection = 'Impor'"
                                class="px-3.5 py-1 rounded-full text-xs font-bold transition cursor-pointer"
                                :class="pairDirection === 'Impor' ? 'bg-navy-900 text-white' : 'text-slate-600'"
                            >
                                {{ locale === 'en' ? 'Import (Asia → ID)' : 'Impor (Asia → RI)' }}
                            </button>
                            <button
                                type="button"
                                @click="pairDirection = 'Ekspor'"
                                class="px-3.5 py-1 rounded-full text-xs font-bold transition cursor-pointer"
                                :class="pairDirection === 'Ekspor' ? 'bg-gold-500 text-navy-950' : 'text-slate-600'"
                            >
                                {{ locale === 'en' ? 'Export (ID → Asia)' : 'Ekspor (RI → Asia)' }}
                            </button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">
                                {{ pairDirection === 'Ekspor' ? (locale === 'en' ? 'Export Destination Country' : 'Negara Tujuan Ekspor') : (locale === 'en' ? 'Origin Country' : 'Negara Asal Impor') }}
                            </label>
                            <select v-model="pairOrigin" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-semibold bg-white">
                                <option v-for="o in origins" :key="o.id" :value="o.name">{{ o.name }}</option>
                            </select>
                        </div>
                        <div class="md:col-span-1 hidden md:flex justify-center pb-2.5 text-gold-600">
                            <ArrowRight :size="20" :class="pairDirection === 'Ekspor' ? 'rotate-180' : ''" class="transition-transform" />
                        </div>
                        <div class="md:col-span-4">
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">
                                {{ pairDirection === 'Ekspor' ? (locale === 'en' ? 'Indonesian Loading Port' : 'Pelabuhan Muat RI') : (locale === 'en' ? 'Indonesian Destination Port' : 'Pelabuhan Tujuan RI') }}
                            </label>
                            <select v-model="pairDest" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-semibold bg-white">
                                <option v-for="d in destinations" :key="d.id" :value="d.name">{{ d.name }}</option>
                            </select>
                        </div>
                        <div class="md:col-span-3">
                            <Link
                                :href="`/kontak?direction=${encodeURIComponent(pairDirection)}&origin=${encodeURIComponent(pairOrigin)}&destination=${encodeURIComponent(pairDest)}`"
                                class="btn-gold-sheen w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm transition"
                            >
                                <span>{{ locale === 'en' ? 'Quote Route' : 'Minta Penawaran' }}</span>
                                <ArrowUpRight :size="16" />
                            </Link>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-slate-100 flex flex-wrap items-center justify-between gap-3 text-xs text-slate-600">
                        <span>
                            {{ locale === 'en' ? 'Selected Corridor:' : 'Rute Terpilih:' }}
                            <strong class="text-navy-950">[{{ pairDirection }}] {{ pairLabel }}</strong>
                        </span>
                        <span>
                            {{ locale === 'en' ? 'Estimated Ocean Transit:' : 'Estimasi Pelayaran Laut:' }}
                            <strong class="text-ocean-600">{{ pairTransit }}</strong>
                        </span>
                    </div>
                </div>
                </MotionReveal>

                <MotionReveal :delay="100">
                    <TradeRouteMap :hubs="tradeHubs" :locale="locale" />
                </MotionReveal>

                <!-- Origin Countries Grid -->
                <MotionReveal :delay="120">
                <div>
                    <div class="flex items-center gap-2 text-sm font-extrabold uppercase tracking-wider text-navy-900 mb-6">
                        <Factory :size="18" class="text-gold-600" />
                        <span>{{ locale === 'en' ? 'Origin Factory Hubs (5 Countries)' : 'Hub Gudang Pabrik Negara Asal (5 Negara)' }}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                        <div
                            v-for="hub in origins"
                            :key="hub.id"
                            class="p-6 rounded-2xl bg-white border border-slate-200 hover:shadow-lg hover:-translate-y-0.5 transition"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-lg font-extrabold text-navy-950">{{ hub.name }}</h3>
                                <span class="px-2.5 py-0.5 rounded-md bg-gold-50 text-gold-600 font-mono text-xs font-bold">{{ hub.code }}</span>
                            </div>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ hub.description }}</p>
                        </div>
                    </div>
                </div>
                </MotionReveal>

                <!-- Destination Ports Grid (Bright Crisp Cards) -->
                <MotionReveal :delay="120">
                <div>
                    <div class="flex items-center gap-2 text-sm font-extrabold uppercase tracking-wider text-navy-900 mb-6">
                        <Anchor :size="18" class="text-ocean-600" />
                        <span>{{ locale === 'en' ? 'Indonesian Maritime Gateways (3 Main Ports)' : 'Gerbang Pelabuhan Tujuan Indonesia (3 Pelabuhan Utama)' }}</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div
                            v-for="hub in destinations"
                            :key="hub.id"
                            class="p-6 rounded-2xl bg-white border-2 border-ocean-500/20 hover:border-gold-500 shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition"
                        >
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-xs font-bold text-gold-600 uppercase">{{ hub.country }}</span>
                                <span class="px-2 py-0.5 rounded-md bg-ocean-50 font-mono text-xs font-bold text-ocean-600">{{ hub.code }}</span>
                            </div>
                            <h3 class="text-xl font-extrabold text-navy-950 mb-2">{{ hub.name }}</h3>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ hub.description }}</p>
                        </div>
                    </div>
                </div>
                </MotionReveal>
            </div>
        </section>

        <CtaBanner :section="cta" :locale="locale" />
    </MainLayout>
</template>
