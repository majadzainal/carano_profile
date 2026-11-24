<script setup>
import { Link } from '@inertiajs/vue3';
import { ArrowUpRight } from 'lucide-vue-next';

defineProps({
    section: { type: Object, default: () => ({}) },
    locale: { type: String, default: 'id' },
});
</script>

<template>
    <section class="py-16 sm:py-20 px-4 sm:px-6 lg:px-8 bg-white">
        <div class="max-w-7xl mx-auto rounded-[2rem] relative overflow-hidden border border-slate-200 shadow-xl bg-ocean-50">
            <!-- Sunlit Maritime Background Photo with Clean Light-to-Navy Editorial Veil -->
            <img
                src="/images/illustrations/sea-freight-vessel.jpg"
                alt=""
                aria-hidden="true"
                class="absolute inset-0 w-full h-full object-cover opacity-20 pointer-events-none"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-ocean-50/90 to-ocean-100/70 pointer-events-none" />

            <div class="relative z-10 p-8 sm:p-14 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8">
                    <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full text-xs font-bold tracking-wider uppercase bg-white text-gold-600 border border-gold-500/30 mb-4 shadow-2xs">
                        {{ section?.badge || (locale === 'en' ? 'READY TO SHIP?' : 'SIAP MENGIRIM?') }}
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-navy-950 leading-tight">
                        {{ section?.title || (locale === 'en' ? 'Discuss Your Import Plan With PT. CARANO UTAMA LOGISTIK.' : 'Diskusikan Kebutuhan Impor Anda Bersama PT. CARANO UTAMA LOGISTIK.') }}
                    </h2>
                    <p class="mt-4 text-slate-600 text-base leading-relaxed max-w-2xl">
                        {{ section?.subtitle }}
                    </p>
                </div>

                <div class="lg:col-span-4 flex flex-col sm:flex-row lg:flex-col gap-3">
                    <Link
                        :href="section?.cta_url || '/kontak'"
                        class="inline-flex items-center justify-center gap-2 px-6 py-4 rounded-2xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-lg shadow-gold-500/20 transition"
                    >
                        <span>{{ section?.cta_label || (locale === 'en' ? 'Request a Quote' : 'Minta Penawaran') }}</span>
                        <ArrowUpRight :size="18" />
                    </Link>
                    <Link
                        v-if="section?.secondary_cta_label"
                        :href="section?.secondary_cta_url || '/alur-pengiriman'"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-2xl bg-white hover:bg-navy-900 hover:text-white text-navy-900 border border-slate-300 font-bold text-sm transition"
                    >
                        {{ section.secondary_cta_label }}
                    </Link>
                </div>
            </div>
        </div>
    </section>
</template>
