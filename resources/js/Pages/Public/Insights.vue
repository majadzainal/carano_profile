<script setup>
import { computed, ref } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import PageParallaxHero from '@/Components/PageParallaxHero.vue';
import MotionReveal from '@/Components/MotionReveal.vue';
import FaqAccordion from '@/Components/FaqAccordion.vue';
import { ArrowRight, Calendar, Search } from 'lucide-vue-next';

const props = defineProps({
    posts: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    activeCategory: { type: String, default: '' },
    faqs: { type: Array, default: () => [] },
});

const page = usePage();
const locale = computed(() => page.props.locale || 'id');
const settings = computed(() => page.props.settings || {});

const searchQuery = ref('');

const filteredPosts = computed(() => {
    const q = searchQuery.value.trim().toLowerCase();
    if (!q) return props.posts;
    return props.posts.filter(
        (p) =>
            (p.title || '').toLowerCase().includes(q) ||
            (p.excerpt || '').toLowerCase().includes(q) ||
            (p.category || '').toLowerCase().includes(q)
    );
});

const filteredFaqs = computed(() => {
    const q = searchQuery.value.trim().toLowerCase();
    if (!q) return props.faqs;
    return props.faqs.filter(
        (f) =>
            (f.question || '').toLowerCase().includes(q) ||
            (f.answer || '').toLowerCase().includes(q)
    );
});
</script>

<template>
    <Head :title="locale === 'en' ? 'Export & Import Logistics Insights' : 'Insight Logistik Ekspor & Impor'" />

    <MainLayout>
        <PageParallaxHero
            :badge="locale === 'en' ? 'KNOWLEDGE HUB' : 'PUSAT EDUKASI & BERITA'"
            :title="locale === 'en' ? 'Export & Import Logistics Insights & FAQ' : 'Insight Logistik Ekspor, Impor & FAQ'"
            :subtitle="
                locale === 'en'
                    ? 'Practical articles on ocean & air freight, PEB/PIB customs compliance, port strategy, and international cargo safety.'
                    : 'Panduan praktis mengenai pengiriman laut & udara, kepabeanan ekspor (PEB) & impor (PIB), strategi pelabuhan, dan keamanan kargo internasional.'
            "
            image="/images/illustrations/port-customs-terminal.jpg"
        >
            <template #below>
                <div class="mt-7 flex flex-col md:flex-row md:items-center gap-4">
                    <div class="flex flex-wrap gap-2">
                        <Link
                            href="/insight"
                            class="px-4 py-2 rounded-full text-xs font-bold border transition"
                            :class="!activeCategory ? 'bg-navy-900 text-white border-navy-900' : 'bg-white text-slate-700 border-slate-300 hover:border-navy-800'"
                        >
                            {{ locale === 'en' ? 'All Categories' : 'Semua Kategori' }}
                        </Link>
                        <Link
                            v-for="cat in categories"
                            :key="cat"
                            :href="`/insight?category=${encodeURIComponent(cat)}`"
                            class="px-4 py-2 rounded-full text-xs font-bold border transition"
                            :class="activeCategory === cat ? 'bg-navy-900 text-white border-navy-900' : 'bg-white text-slate-700 border-slate-300 hover:border-navy-800'"
                        >
                            {{ cat }}
                        </Link>
                    </div>

                    <div class="relative w-full md:w-64">
                        <Search :size="16" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                        <input
                            v-model="searchQuery"
                            type="text"
                            :placeholder="locale === 'en' ? 'Search articles or FAQ...' : 'Cari artikel atau FAQ...'"
                            class="w-full pl-10 pr-4 py-2 rounded-full bg-white border border-slate-300 text-navy-950 text-sm placeholder:text-slate-400 outline-none focus:border-navy-800"
                        />
                    </div>
                </div>
            </template>
        </PageParallaxHero>

        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-20">
                <div v-if="filteredPosts.length" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <MotionReveal v-for="(post, pIdx) in filteredPosts" :key="post.id" :delay="pIdx * 80">
                    <Link
                        :href="`/insight/${post.slug}`"
                        class="group h-full bg-white rounded-3xl border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all flex flex-col justify-between"
                    >
                        <div>
                            <div class="h-48 bg-gradient-to-br from-navy-900 to-ocean-600 relative overflow-hidden flex items-center justify-center">
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
                                <h2 class="text-lg font-extrabold text-navy-950 group-hover:text-ocean-600 transition">
                                    {{ post.title }}
                                </h2>
                                <p class="mt-2.5 text-sm text-slate-600 leading-relaxed line-clamp-3">{{ post.excerpt }}</p>
                            </div>
                        </div>
                        <div class="px-6 pb-6 pt-2 text-xs font-bold text-navy-900 group-hover:text-gold-600 inline-flex items-center gap-1">
                            {{ locale === 'en' ? 'Read Full Article' : 'Baca Selengkapnya' }}
                            <ArrowRight :size="14" />
                        </div>
                    </Link>
                    </MotionReveal>
                </div>
                <div v-else class="text-center py-12 text-slate-500 text-sm">
                    {{ locale === 'en' ? 'No articles match your search.' : 'Tidak ada artikel yang cocok dengan pencarian Anda.' }}
                </div>

                <div v-if="filteredFaqs.length">
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-navy-950 mb-6">
                        {{ locale === 'en' ? 'Frequently Asked Questions' : 'Pertanyaan yang Sering Diajukan (FAQ)' }}
                    </h2>
                    <FaqAccordion :faqs="filteredFaqs" />
                </div>
            </div>
        </section>
    </MainLayout>
</template>
