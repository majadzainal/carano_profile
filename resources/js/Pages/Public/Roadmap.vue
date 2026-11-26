<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import ShipmentRoadmap from '@/Components/ShipmentRoadmap.vue';
import CtaBanner from '@/Components/CtaBanner.vue';
import { ArrowUpRight, CheckCircle2, ClipboardCheck, Download } from 'lucide-vue-next';

defineProps({
    intro: { type: Object, default: () => ({}) },
    roadmapSteps: { type: Array, default: () => [] },
    cta: { type: Object, default: () => ({}) },
});

const page = usePage();
const locale = computed(() => page.props.locale || 'id');
const settings = computed(() => page.props.settings || {});

// Interactive Export & Import Document Readiness Checklist
const checklistMode = ref('import'); // import | export
const checkedDocs = ref(['invoice', 'packing_list', 'bl', 'exp_invoice', 'exp_peb']);

const docGroups = computed(() => {
    if (checklistMode.value === 'export') {
        return [
            {
                phase: locale.value === 'en' ? 'Exporter & Origin Prep (Indonesia)' : 'Persiapan Eksportir & Stuffing (Indonesia)',
                items: [
                    { id: 'exp_invoice', label: 'Commercial Invoice & Packing List' },
                    { id: 'exp_nib', label: locale.value === 'en' ? 'Exporter Registration (NIB / Legal Entity)' : 'Legalitas Eksportir (NIB / NPWP)' },
                    { id: 'exp_stuffing', label: locale.value === 'en' ? 'Strapping, Stuffing & Fumigation (if required)' : 'Standar Strapping, Stuffing & Fumigasi (bila perlu)' },
                ],
            },
            {
                phase: locale.value === 'en' ? 'Export Customs & Ocean Carrier' : 'Kepabeanan Ekspor (PEB) & Pelayaran',
                items: [
                    { id: 'exp_peb', label: 'PEB (Pemberitahuan Ekspor Barang) & NPE' },
                    { id: 'exp_coo', label: 'SKA / Certificate of Origin (Form E / IJEPA / AK / D)' },
                    { id: 'exp_bl', label: 'Shipping Instruction (SI) & Bill of Lading (B/L)' },
                ],
            },
        ];
    }
    return [
        {
            phase: locale.value === 'en' ? 'Origin & Export Docs (Steps 1–4)' : 'Dokumen Negara Asal (Tahap 1–4)',
            items: [
                { id: 'invoice', label: 'Commercial Invoice & Packing List' },
                { id: 'coo', label: 'Certificate of Origin (Form E / IJEPA / AK)' },
                { id: 'insurance', label: locale.value === 'en' ? 'Marine Cargo Insurance Policy' : 'Polis Asuransi Kargo Laut' },
            ],
        },
        {
            phase: locale.value === 'en' ? 'Ocean & Terminal Docs (Steps 5–10)' : 'Dokumen Pelayaran & Bea Cukai RI (Tahap 5–10)',
            items: [
                { id: 'bl', label: 'Bill of Lading (B/L) / Telex Release' },
                { id: 'pib', label: 'PIB (Pemberitahuan Impor Barang) & HS Code' },
                { id: 'sppb', label: 'DO Pelayaran & SPPB (Izin Keluar Terminal)' },
            ],
        },
    ];
});

const currentDocIds = computed(() => docGroups.value.flatMap((g) => g.items.map((i) => i.id)));
const readinessPercent = computed(() => {
    const ids = currentDocIds.value;
    if (!ids.length) return 0;
    const count = ids.filter((id) => checkedDocs.value.includes(id)).length;
    return Math.round((count / ids.length) * 100);
});

const toggleDoc = (id) => {
    if (checkedDocs.value.includes(id)) {
        checkedDocs.value = checkedDocs.value.filter((x) => x !== id);
    } else {
        checkedDocs.value.push(id);
    }
};
</script>

<template>
    <Head :title="locale === 'en' ? '10-Step Shipment Road Map' : 'Road Map Shipment 10 Tahap'" />

    <MainLayout>
        <PageParallaxHero
            :badge="intro?.badge || 'ROAD MAP SHIPMENT'"
            :title="intro?.title || '10 Tahap Road Map Shipment'"
            :subtitle="intro?.subtitle"
            image="/images/illustrations/hero-port-maritime.jpg"
        >
            <template #aside>
                <a
                    :href="settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                    target="_blank"
                    class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full bg-gold-500 hover:bg-gold-400 text-navy-950 text-sm font-extrabold shadow-md transition shrink-0"
                >
                    <Download :size="17" />
                    <span>{{ locale === 'en' ? 'Download Official PDF' : 'Unduh Dokumen PDF Resmi' }}</span>
                </a>
            </template>
        </PageParallaxHero>

        <section class="py-16 bg-ocean-50/70">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
                <MotionReveal>
                    <ShipmentRoadmap
                        :steps="roadmapSteps"
                        :locale="locale"
                        :brochure-url="settings.brochure_pdf || '/uploads/docs/CARANO_Road_Map_Shipment.pdf'"
                    />
                </MotionReveal>

                <!-- Interactive Import Document Readiness Checklist -->
                <MotionReveal :delay="100">
                <div class="bg-white rounded-3xl border border-slate-200 p-7 sm:p-9 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                        <div>
                            <div class="inline-flex items-center gap-2 text-xs font-extrabold uppercase tracking-wider text-gold-600 mb-1">
                                <ClipboardCheck :size="16" />
                                <span>{{ locale === 'en' ? 'Interactive Export & Import Readiness Check' : 'Cek Kesiapan Dokumen Ekspor & Impor' }}</span>
                            </div>
                            <h2 class="text-2xl font-extrabold text-navy-950">
                                {{ locale === 'en' ? 'Check Documents You Already Have' : 'Centang Dokumen yang Sudah Tersedia' }}
                            </h2>
                            <div class="mt-3 inline-flex items-center bg-slate-100 p-1 rounded-full border border-slate-200">
                                <button
                                    type="button"
                                    @click="checklistMode = 'import'"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition cursor-pointer"
                                    :class="checklistMode === 'import' ? 'bg-navy-900 text-white' : 'text-slate-600'"
                                >
                                    {{ locale === 'en' ? 'Import (PIB)' : 'Checklist Impor (PIB)' }}
                                </button>
                                <button
                                    type="button"
                                    @click="checklistMode = 'export'"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold transition cursor-pointer"
                                    :class="checklistMode === 'export' ? 'bg-gold-500 text-navy-950' : 'text-slate-600'"
                                >
                                    {{ locale === 'en' ? 'Export (PEB & SKA)' : 'Checklist Ekspor (PEB & SKA)' }}
                                </button>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-slate-500 font-semibold">{{ locale === 'en' ? 'Document Readiness' : 'Kesiapan Dokumen' }}</div>
                            <div class="text-3xl font-extrabold text-navy-900">{{ readinessPercent }}%</div>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div v-for="group in docGroups" :key="group.phase" class="space-y-3">
                            <div class="text-xs font-bold uppercase tracking-wider text-ocean-600">{{ group.phase }}</div>
                            <button
                                v-for="doc in group.items"
                                :key="doc.id"
                                type="button"
                                @click="toggleDoc(doc.id)"
                                class="w-full flex items-center justify-between gap-3 p-4 rounded-2xl border text-left transition cursor-pointer"
                                :class="
                                    checkedDocs.includes(doc.id)
                                        ? 'bg-emerald-50/70 border-emerald-300 text-navy-950'
                                        : 'bg-slate-50 border-slate-200 text-slate-600 hover:border-navy-800'
                                "
                            >
                                <span class="text-sm font-bold">{{ doc.label }}</span>
                                <CheckCircle2
                                    :size="20"
                                    :class="checkedDocs.includes(doc.id) ? 'text-emerald-600' : 'text-slate-300'"
                                />
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 pt-5 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <p class="text-xs text-slate-600">
                            {{
                                readinessPercent === 100
                                    ? locale === 'en'
                                        ? 'All core documents ready! Let CARANO execute your shipment immediately.'
                                        : 'Dokumen utama lengkap! Tim CARANO siap memproses pengiriman Anda.'
                                    : locale === 'en'
                                    ? 'Missing documents? PT. CARANO UTAMA LOGISTIK handles origin docs, insurance & terminal customs for you.'
                                    : 'Ada dokumen yang belum siap? PT. CARANO UTAMA LOGISTIK siap mengurus dokumen ekspor, asuransi, hingga Bea Cukai Anda.'
                            }}
                        </p>
                        <Link
                            href="/kontak"
                            class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-full bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold transition"
                        >
                            <span>{{ locale === 'en' ? 'Consult Document Requirements' : 'Konsultasi Kelengkapan Dokumen' }}</span>
                            <ArrowUpRight :size="15" class="text-gold-400" />
                        </Link>
                    </div>
                </div>
                </MotionReveal>
            </div>
        </section>

        <CtaBanner :section="cta" :locale="locale" />
    </MainLayout>
</template>
