<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import CtaBanner from '@/Components/CtaBanner.vue';
import IconMapper from '@/Components/IconMapper.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import { ArrowRight, ArrowUpRight, Calculator, CheckCircle2, Clock, Ship } from 'lucide-vue-next';

const props = defineProps({
    intro: { type: Object, default: () => ({}) },
    services: { type: Array, default: () => [] },
    cta: { type: Object, default: () => ({}) },
});

const locale = computed(() => usePage().props.locale || 'id');

// Interactive Shipment Planner / Estimator
const simOrigin = ref('Jepang');
const simPort = ref('Pelabuhan Tanjung Priok');
const simMode = ref('FCL 20ft');
const simAddons = ref(['strapping', 'insurance', 'customs', 'delivery']);

const originDays = {
    Jepang: [10, 14],
    China: [9, 14],
    Taiwan: [8, 12],
    'Korea Selatan': [11, 15],
    Singapura: [3, 5],
};

const addonOptions = computed(() =>
    locale.value === 'en'
        ? [
              { key: 'strapping', label: 'Origin Factory Strapping & Pickup' },
              { key: 'origin_docs', label: 'Origin Export Docs & Local Tax' },
              { key: 'insurance', label: 'Marine Cargo Insurance' },
              { key: 'customs', label: 'Terminal Customs Clearance (PIB/SPPB)' },
              { key: 'delivery', label: 'Stripping & Door-to-Door Trucking' },
          ]
        : [
              { key: 'strapping', label: 'Strapping & Pickup Gudang Pabrik Asal' },
              { key: 'origin_docs', label: 'Dokumen Ekspor & Pajak Negara Asal' },
              { key: 'insurance', label: 'Asuransi Kargo Laut' },
              { key: 'customs', label: 'Pengurusan Pajak & Bea Cukai Terminal' },
              { key: 'delivery', label: 'Stripping & Trucking ke Lokasi Tujuan' },
          ]
);

const toggleAddon = (key) => {
    if (simAddons.value.includes(key)) {
        simAddons.value = simAddons.value.filter((k) => k !== key);
    } else {
        simAddons.value.push(key);
    }
};

const estimatedTransit = computed(() => {
    if (simMode.value === 'Air Freight') return locale.value === 'en' ? '2–4 Days (Express Air)' : '2–4 Hari (Kargo Udara)';
    const [minD, maxD] = originDays[simOrigin.value] || [8, 14];
    const portDelta = simPort.value.includes('Priok') ? 0 : 2;
    return locale.value === 'en'
        ? `${minD + portDelta}–${maxD + portDelta} Days (Port-to-Port)`
        : `${minD + portDelta}–${maxD + portDelta} Hari (Pelayaran Laut)`;
});

const prefillContactUrl = computed(() => {
    const selectedLabels = addonOptions.value
        .filter((a) => simAddons.value.includes(a.key))
        .map((a) => a.label)
        .join(', ');
    const notes = `Moda: ${simMode.value} | Rute: ${simOrigin.value} -> ${simPort.value} | Cakupan: ${selectedLabels || 'Standard'}`;
    return `/kontak?origin=${encodeURIComponent(simOrigin.value)}&destination=${encodeURIComponent(simPort.value)}&notes=${encodeURIComponent(notes)}`;
});
</script>

<template>
    <Head :title="locale === 'en' ? 'Logistics Services' : 'Layanan Logistik'" />

    <MainLayout>
        <PageParallaxHero
            :badge="intro?.badge || (locale === 'en' ? 'OUR SOLUTIONS' : 'SOLUSI LAYANAN')"
            :title="intro?.title || (locale === 'en' ? 'Integrated Multimodal & Import Services' : 'Layanan Impor & Logistik Terintegrasi')"
            :subtitle="intro?.subtitle"
            image="/images/illustrations/sea-freight-vessel.jpg"
        />

        <!-- INTERACTIVE SHIPMENT SCOPE & TRANSIT SIMULATOR -->
        <section class="bg-ocean-50/70 py-14 border-b border-slate-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <MotionReveal>
                <div class="bg-white rounded-3xl border border-slate-200 shadow-lg p-6 sm:p-9">
                    <div class="flex items-center gap-2.5 text-xs font-extrabold uppercase tracking-wider text-gold-600 mb-2">
                        <Calculator :size="16" />
                        <span>{{ locale === 'en' ? 'Interactive Shipment Scope Simulator' : 'Simulator Cakupan & Estimasi Pengiriman' }}</span>
                    </div>
                    <h2 class="text-2xl font-extrabold text-navy-950 mb-6">
                        {{ locale === 'en' ? 'Configure Your Import Plan in Seconds' : 'Simulasikan Rencana Impor Anda' }}
                    </h2>

                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                        <div class="lg:col-span-7 space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">{{ locale === 'en' ? 'Origin' : 'Negara Asal' }}</label>
                                    <select v-model="simOrigin" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-semibold bg-white">
                                        <option v-for="o in Object.keys(originDays)" :key="o" :value="o">{{ o }}</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">{{ locale === 'en' ? 'Indonesian Port' : 'Pelabuhan Tujuan' }}</label>
                                    <select v-model="simPort" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-semibold bg-white">
                                        <option value="Pelabuhan Tanjung Priok">Tanjung Priok (Jakarta)</option>
                                        <option value="Pelabuhan Tanjung Emas">Tanjung Emas (Semarang)</option>
                                        <option value="Pelabuhan Tanjung Perak">Tanjung Perak (Surabaya)</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">{{ locale === 'en' ? 'Shipment Mode' : 'Moda / Kontainer' }}</label>
                                    <select v-model="simMode" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-semibold bg-white">
                                        <option value="FCL 20ft">FCL 20ft Container</option>
                                        <option value="FCL 40ft / 40HQ">FCL 40ft / 40HQ</option>
                                        <option value="LCL Consolidation">LCL Konsolidasi</option>
                                        <option value="Air Freight">Air Freight Express</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div class="text-xs font-bold uppercase text-navy-900 mb-2.5">
                                    {{ locale === 'en' ? 'Select End-to-End Scope:' : 'Pilih Cakupan Layanan:' }}
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <button
                                        v-for="ad in addonOptions"
                                        :key="ad.key"
                                        type="button"
                                        @click="toggleAddon(ad.key)"
                                        class="flex items-center gap-2.5 p-3 rounded-xl border text-left text-xs font-bold transition cursor-pointer"
                                        :class="
                                            simAddons.includes(ad.key)
                                                ? 'bg-navy-900 text-white border-navy-900'
                                                : 'bg-slate-50 text-slate-600 border-slate-200 hover:border-navy-800'
                                        "
                                    >
                                        <CheckCircle2 :size="16" :class="simAddons.includes(ad.key) ? 'text-gold-400' : 'text-slate-300'" />
                                        <span>{{ ad.label }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Live Summary Box (Clean Light Accent) -->
                        <div class="lg:col-span-5 rounded-2xl bg-ocean-50 border border-slate-200 p-6 space-y-4">
                            <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                                <span class="text-xs font-extrabold uppercase text-ocean-600">{{ locale === 'en' ? 'Live Estimate Summary' : 'Ringkasan Simulasi' }}</span>
                                <Ship :size="18" class="text-gold-600" />
                            </div>
                            <div class="space-y-2 text-sm text-navy-950">
                                <div class="flex justify-between"><span class="text-slate-500">{{ locale === 'en' ? 'Corridor' : 'Koridor' }}:</span><span class="font-bold">{{ simOrigin }} → {{ simPort.replace('Pelabuhan ', '') }}</span></div>
                                <div class="flex justify-between"><span class="text-slate-500">{{ locale === 'en' ? 'Mode' : 'Moda' }}:</span><span class="font-bold text-gold-600">{{ simMode }}</span></div>
                                <div class="flex justify-between items-center pt-2 border-t border-slate-200">
                                    <span class="text-slate-500 inline-flex items-center gap-1"><Clock :size="14" /> {{ locale === 'en' ? 'Est. Transit' : 'Est. Transit' }}:</span>
                                    <span class="font-extrabold text-ocean-600">{{ estimatedTransit }}</span>
                                </div>
                            </div>
                            <div class="text-xs text-slate-600 bg-white border border-slate-200 rounded-xl p-3">
                                {{ simAddons.length }} {{ locale === 'en' ? 'integrated handling stages selected.' : 'tahap penanganan terintegrasi dipilih.' }}
                            </div>
                            <Link
                                :href="prefillContactUrl"
                                class="w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-sm transition"
                            >
                                <span>{{ locale === 'en' ? 'Request Exact Quote With This Setup' : 'Minta Penawaran dengan Konfigurasi Ini' }}</span>
                                <ArrowUpRight :size="16" />
                            </Link>
                        </div>
                    </div>
                </div>
                </MotionReveal>
            </div>
        </section>

        <!-- Service Pillars List with Real Sunlit Maritime Photography -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
                <MotionReveal v-for="(service, idx) in services" :key="service.id" :delay="idx * 80">
                    <div class="rounded-3xl border border-slate-200 bg-white overflow-hidden hover:shadow-xl hover:border-ocean-500/40 transition-all grid grid-cols-1 lg:grid-cols-12 items-stretch">
                        <div class="lg:col-span-4 relative min-h-[220px] bg-ocean-100 overflow-hidden">
                            <img
                                :src="service.image_path || '/images/illustrations/sea-freight-vessel.jpg'"
                                :alt="service.title"
                                class="w-full h-full object-cover hover:scale-105 transition duration-700"
                            />
                            <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-white/95 text-navy-900 text-xs font-extrabold uppercase shadow-sm">
                                {{ locale === 'en' ? 'Pillar' : 'Pilar' }} 0{{ idx + 1 }}
                            </span>
                        </div>

                        <div class="lg:col-span-8 p-7 sm:p-9 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-ocean-50 text-navy-900">
                                        <IconMapper :name="service.icon" :size="20" />
                                    </span>
                                    <span class="px-3 py-1 rounded-full bg-gold-50 text-gold-600 text-xs font-bold uppercase border border-gold-500/20">
                                        {{ service.badge }}
                                    </span>
                                </div>
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-950">{{ service.title }}</h2>
                                <p class="mt-3 text-slate-600 leading-relaxed">{{ service.short_desc }}</p>
                                <ul v-if="service.features?.length" class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                                    <li v-for="(f, i) in service.features" :key="i" class="flex items-start gap-2 text-sm font-medium text-navy-900">
                                        <CheckCircle2 :size="16" class="text-gold-600 shrink-0 mt-0.5" />
                                        <span>{{ f }}</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                                <Link
                                    :href="`/layanan/${service.slug}`"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-navy-900 hover:bg-navy-800 text-white text-sm font-bold transition"
                                >
                                    <span>{{ locale === 'en' ? 'View Full Details' : 'Lihat Detail Lengkap' }}</span>
                                    <ArrowRight :size="16" class="text-gold-400" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </MotionReveal>
            </div>
        </section>

        <CtaBanner :section="cta" :locale="locale" />
    </MainLayout>
</template>
