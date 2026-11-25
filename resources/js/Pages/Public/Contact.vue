<script setup>
import { computed } from 'vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import FaqAccordion from '@/Components/FaqAccordion.vue';
import LottiePlayer from '@/Components/LottiePlayer.vue';
import customsVerifiedAnim from '@/assets/lottie/customs-verified.json';
import {
    CheckCircle2,
    Clock,
    ExternalLink,
    Globe,
    Mail,
    MapPin,
    MessageCircle,
    Phone,
    Send,
} from 'lucide-vue-next';

const props = defineProps({
    origins: { type: Array, default: () => [] },
    destinations: { type: Array, default: () => [] },
    services: { type: Array, default: () => [] },
    faqs: { type: Array, default: () => [] },
    prefill: { type: Object, default: () => ({}) },
});

const page = usePage();
const locale = computed(() => page.props.locale || 'id');
const settings = computed(() => page.props.settings || {});
const flashSuccess = computed(() => page.props.flash?.success);

const form = useForm({
    company_name: '',
    contact_name: '',
    email: '',
    phone: '',
    origin_country: props.prefill?.origin || props.origins[0]?.name || 'Jepang',
    destination_port: props.prefill?.destination || props.destinations[0]?.name || 'Pelabuhan Tanjung Priok',
    service_type: props.prefill?.service || props.services[0]?.title || 'Sea Freight Impor (FCL & LCL)',
    cargo_details: props.prefill?.notes || '',
});

const submit = () => {
    form.post('/kontak/inquiry', {
        preserveScroll: true,
        onSuccess: () => form.reset('cargo_details'),
    });
};

const waDirectUrl = computed(() => {
    const num = (settings.value.contact_whatsapp || '622138312253').replace(/[^0-9]/g, '');
    const msg = `Halo PT. CARANO UTAMA LOGISTIK, saya ${form.contact_name || 'Calon Klien'} (${form.company_name || '-'}) ingin meminta penawaran rute ${form.origin_country} -> ${form.destination_port} (${form.service_type}). ${form.cargo_details || ''}`;
    return `https://wa.me/${num}?text=${encodeURIComponent(msg)}`;
});

const mapEmbedSrc = computed(() => {
    const addr = settings.value.contact_address || 'Jl. Duta Boulevard Barat No.C-10, Harapan Baru, Bekasi Utara, Kota Bekasi, Jawa Barat 17123';
    return `https://maps.google.com/maps?q=${encodeURIComponent(addr)}&t=&z=16&ie=UTF8&iwloc=&output=embed`;
});
</script>

<template>
    <Head :title="locale === 'en' ? 'Contact & Request a Quote' : 'Kontak & Minta Penawaran'" />

    <MainLayout>
        <PageParallaxHero
            :badge="locale === 'en' ? 'REQUEST A QUOTATION' : 'KONSULTASI & PENAWARAN'"
            :title="locale === 'en' ? 'Start Your Import Shipment Consultation' : 'Mulai Konsultasi Pengiriman Impor Anda'"
            :subtitle="
                locale === 'en'
                    ? 'Share your origin hub, destination port, and cargo volume. Our specialists will prepare a transparent quotation.'
                    : 'Sampaikan negara asal, pelabuhan tujuan, dan estimasi volume kargo Anda. Tim konsultan PT. CARANO UTAMA LOGISTIK siap memberikan penawaran transparan.'
            "
            image="/images/illustrations/hero-port-maritime.jpg"
        />

        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-10">
                <!-- Smart B2B RFQ Form -->
                <MotionReveal class="lg:col-span-7 space-y-8">
                    <div class="bg-white rounded-3xl border border-slate-200 p-7 sm:p-9 shadow-sm">
                        <div
                            v-if="flashSuccess"
                            class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 flex items-center gap-3 text-sm font-medium"
                        >
                            <LottiePlayer :animation-data="customsVerifiedAnim" :loop="false" class="w-14 h-12 shrink-0" />
                            <div>{{ flashSuccess }}</div>
                        </div>

                        <form @submit.prevent="submit" class="space-y-5">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        {{ locale === 'en' ? 'Company Name *' : 'Nama Perusahaan *' }}
                                    </label>
                                    <input
                                        v-model="form.company_name"
                                        type="text"
                                        required
                                        placeholder="PT. Contoh Industri Indonesia"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                                    />
                                    <p v-if="form.errors.company_name" class="text-xs text-rose-600 mt-1">{{ form.errors.company_name }}</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        {{ locale === 'en' ? 'Contact Person *' : 'Nama Lengkap PIC *' }}
                                    </label>
                                    <input
                                        v-model="form.contact_name"
                                        type="text"
                                        required
                                        placeholder="Nama Anda"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                                    />
                                    <p v-if="form.errors.contact_name" class="text-xs text-rose-600 mt-1">{{ form.errors.contact_name }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        Email *
                                    </label>
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        required
                                        placeholder="email@perusahaan.co.id"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                                    />
                                    <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        {{ locale === 'en' ? 'Phone / WhatsApp *' : 'Telepon / WhatsApp *' }}
                                    </label>
                                    <input
                                        v-model="form.phone"
                                        type="text"
                                        required
                                        placeholder="0812 xxxx xxxx"
                                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                                    />
                                    <p v-if="form.errors.phone" class="text-xs text-rose-600 mt-1">{{ form.errors.phone }}</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        {{ locale === 'en' ? 'Origin Country' : 'Negara Asal' }}
                                    </label>
                                    <select
                                        v-model="form.origin_country"
                                        class="w-full rounded-xl border border-slate-300 px-3.5 py-3 text-sm bg-white focus:border-navy-800 outline-none"
                                    >
                                        <option v-for="o in origins" :key="o.id" :value="o.name">{{ o.name }}</option>
                                        <option value="Lainnya">Lainnya / Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        {{ locale === 'en' ? 'Destination Port' : 'Pelabuhan Tujuan' }}
                                    </label>
                                    <select
                                        v-model="form.destination_port"
                                        class="w-full rounded-xl border border-slate-300 px-3.5 py-3 text-sm bg-white focus:border-navy-800 outline-none"
                                    >
                                        <option v-for="d in destinations" :key="d.id" :value="d.name">{{ d.name }}</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                        {{ locale === 'en' ? 'Service Needed' : 'Layanan' }}
                                    </label>
                                    <select
                                        v-model="form.service_type"
                                        class="w-full rounded-xl border border-slate-300 px-3.5 py-3 text-sm bg-white focus:border-navy-800 outline-none"
                                    >
                                        <option v-for="s in services" :key="s.id" :value="s.title">{{ s.title }}</option>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">
                                    {{ locale === 'en' ? 'Cargo Details & Estimated Volume *' : 'Detail Komoditas & Estimasi Volume (FCL/LCL) *' }}
                                </label>
                                <textarea
                                    v-model="form.cargo_details"
                                    rows="4"
                                    required
                                    :placeholder="
                                        locale === 'en'
                                            ? 'Example: 1x20ft FCL industrial spare parts from Osaka to Cikarang, including customs clearance & insurance.'
                                            : 'Contoh: 1x20ft FCL komponen mesin dari Osaka menuju Cikarang, termasuk pengurusan bea cukai & asuransi.'
                                    "
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                                />
                                <p v-if="form.errors.cargo_details" class="text-xs text-rose-600 mt-1">{{ form.errors.cargo_details }}</p>
                            </div>

                            <div class="flex flex-wrap items-center gap-3 pt-2">
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="btn-gold-sheen inline-flex items-center gap-2 px-7 py-3.5 rounded-full bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-md disabled:opacity-60 cursor-pointer"
                                >
                                    <Send :size="16" />
                                    <span>{{ form.processing ? 'Mengirim...' : locale === 'en' ? 'Submit Quotation Request' : 'Kirim Permintaan Penawaran' }}</span>
                                </button>

                                <a
                                    :href="waDirectUrl"
                                    target="_blank"
                                    class="inline-flex items-center gap-2 px-5 py-3.5 rounded-full bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm transition"
                                >
                                    <MessageCircle :size="16" />
                                    <span>{{ locale === 'en' ? 'Chat via WhatsApp' : 'Lanjut via WhatsApp' }}</span>
                                </a>
                            </div>
                        </form>
                    </div>

                    <div v-if="faqs.length">
                        <h3 class="text-lg font-extrabold text-navy-950 mb-3">
                            {{ locale === 'en' ? 'Quick Answers' : 'Pertanyaan Singkat' }}
                        </h3>
                        <FaqAccordion :faqs="faqs" />
                    </div>
                </MotionReveal>

                <!-- Right Bright Office Contact Card & Interactive Google Map -->
                <MotionReveal class="lg:col-span-5 space-y-6" :delay="120">
                    <div class="rounded-3xl bg-ocean-50 border border-slate-200 p-7 sm:p-8 space-y-5 shadow-xs">
                        <div class="flex items-center gap-3.5 pb-5 border-b border-slate-200">
                            <img
                                :src="settings.logo_light || '/images/brand/logo-carano-light.png'"
                                :alt="settings.company_name"
                                class="h-16 w-16 object-contain"
                            />
                            <div>
                                <div class="font-extrabold text-base text-navy-950">{{ settings.company_name }}</div>
                                <div class="text-xs font-bold text-gold-600">{{ settings.company_tagline }}</div>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm text-slate-700">
                            <div class="flex items-start gap-3">
                                <MapPin :size="18" class="text-gold-600 shrink-0 mt-0.5" />
                                <div>
                                    <div class="font-medium">{{ settings.contact_address }}</div>
                                    <a
                                        v-if="settings.contact_maps_url"
                                        :href="settings.contact_maps_url"
                                        target="_blank"
                                        rel="noopener"
                                        class="inline-flex items-center gap-1 text-xs font-bold text-ocean-600 hover:text-gold-600 mt-1.5"
                                    >
                                        <span>{{ locale === 'en' ? 'Open Direction on Google Maps' : 'Buka Petunjuk Arah di Google Maps' }}</span>
                                        <ExternalLink :size="13" />
                                    </a>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <Phone :size="18" class="text-gold-600 shrink-0" />
                                <a :href="`tel:${(settings.contact_phone || '02138312253').replace(/[^0-9+]/g, '')}`" class="hover:text-navy-950 font-bold text-navy-900">
                                    {{ settings.contact_phone }}
                                </a>
                            </div>
                            <div v-if="settings.contact_website" class="flex items-center gap-3">
                                <Globe :size="18" class="text-gold-600 shrink-0" />
                                <a :href="settings.contact_website" target="_blank" rel="noopener" class="hover:text-navy-950 font-medium text-ocean-600">
                                    {{ settings.contact_website.replace(/^https?:\/\//, '').replace(/\/$/, '') }}
                                </a>
                            </div>
                            <div class="flex items-center gap-3">
                                <Mail :size="18" class="text-gold-600 shrink-0" />
                                <a :href="`mailto:${settings.contact_email}`" class="hover:text-navy-950 font-medium">{{ settings.contact_email }}</a>
                            </div>
                            <div class="flex items-start gap-3">
                                <Clock :size="18" class="text-gold-600 shrink-0 mt-0.5" />
                                <span>{{ settings.business_hours }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Interactive Embedded Google Map -->
                    <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100">
                        <div class="px-5 py-3.5 bg-white border-b border-slate-200 flex items-center justify-between">
                            <span class="text-xs font-extrabold uppercase tracking-wider text-navy-900">
                                {{ locale === 'en' ? 'Office Location Map' : 'Peta Lokasi Kantor' }}
                            </span>
                            <a
                                :href="settings.contact_maps_url || 'https://maps.app.goo.gl/8u9aomAeqFG2EM7H7'"
                                target="_blank"
                                rel="noopener"
                                class="inline-flex items-center gap-1 text-xs font-bold text-ocean-600 hover:text-navy-900"
                            >
                                Google Maps <ExternalLink :size="12" />
                            </a>
                        </div>
                        <iframe
                            :src="mapEmbedSrc"
                            class="w-full h-72 border-0"
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Lokasi Kantor PT. CARANO UTAMA LOGISTIK"
                        />
                    </div>
                </MotionReveal>
            </div>
        </section>
    </MainLayout>
</template>
