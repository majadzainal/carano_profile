<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import IconMapper from '@/Components/IconMapper.vue';
import { ArrowLeft, ArrowUpRight, CheckCircle2 } from 'lucide-vue-next';

defineProps({
    service: { type: Object, required: true },
    otherServices: { type: Array, default: () => [] },
});

const locale = computed(() => usePage().props.locale || 'id');
</script>

<template>
    <Head :title="service.title" />

    <MainLayout>
        <PageParallaxHero
            :badge="service.badge"
            :title="service.title"
            :subtitle="service.short_desc"
            :image="service.image_path || '/images/illustrations/sea-freight-vessel.jpg'"
        >
            <template #below>
                <Link href="/layanan" class="mt-5 inline-flex items-center gap-1.5 text-xs font-bold text-ocean-600 hover:text-navy-900">
                    <ArrowLeft :size="15" />
                    {{ locale === 'en' ? 'Back to All Services' : 'Kembali ke Semua Layanan' }}
                </Link>
            </template>
        </PageParallaxHero>

        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-12">
                <MotionReveal class="lg:col-span-8">
                    <img
                        v-if="service.image_path"
                        :src="service.image_path"
                        :alt="service.title"
                        class="w-full max-h-96 object-cover rounded-3xl mb-8 border border-slate-200 shadow-md"
                    />
                    <div class="prose-carano" v-html="service.body" />
                </MotionReveal>

                <aside class="lg:col-span-4 space-y-6">
                    <div class="p-6 rounded-3xl bg-ocean-50 border border-slate-200">
                        <h3 class="text-base font-extrabold text-navy-950 mb-4">
                            {{ locale === 'en' ? 'Key Highlights' : 'Poin Utama Layanan' }}
                        </h3>
                        <ul class="space-y-3">
                            <li v-for="(f, i) in service.features" :key="i" class="flex items-start gap-2.5 text-sm text-navy-900 font-medium">
                                <CheckCircle2 :size="17" class="text-gold-600 shrink-0 mt-0.5" />
                                <span>{{ f }}</span>
                            </li>
                        </ul>
                        <Link
                            href="/kontak"
                            class="mt-6 w-full inline-flex items-center justify-center gap-2 px-5 py-3.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm transition"
                        >
                            <span>{{ locale === 'en' ? 'Request Quotation' : 'Minta Penawaran Layanan Ini' }}</span>
                            <ArrowUpRight :size="16" />
                        </Link>
                    </div>

                    <div v-if="otherServices.length" class="p-6 rounded-3xl bg-white border border-slate-200">
                        <h3 class="text-sm font-extrabold uppercase tracking-wider text-slate-500 mb-4">
                            {{ locale === 'en' ? 'Other Services' : 'Layanan Lainnya' }}
                        </h3>
                        <div class="space-y-2">
                            <Link
                                v-for="o in otherServices"
                                :key="o.id"
                                :href="`/layanan/${o.slug}`"
                                class="block p-3 rounded-xl hover:bg-ocean-50 text-sm font-bold text-navy-900 transition"
                            >
                                {{ o.title }}
                            </Link>
                        </div>
                    </div>
                </aside>
            </div>
        </section>
    </MainLayout>
</template>
