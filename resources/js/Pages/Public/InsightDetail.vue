<script setup>
import { computed } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
import { ArrowLeft, ArrowUpRight, Calendar, User } from 'lucide-vue-next';

defineProps({
    post: { type: Object, required: true },
    relatedPosts: { type: Array, default: () => [] },
});

const locale = computed(() => usePage().props.locale || 'id');
</script>

<template>
    <Head :title="post.title" />

    <MainLayout>
        <article class="py-12 sm:py-16 bg-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <Link href="/insight" class="inline-flex items-center gap-1.5 text-xs font-bold text-ocean-600 hover:text-navy-900 mb-6">
                    <ArrowLeft :size="15" />
                    {{ locale === 'en' ? 'Back to Insights' : 'Kembali ke Insight' }}
                </Link>

                <div class="flex flex-wrap items-center gap-3 text-xs text-slate-500 mb-4">
                    <span class="px-3 py-1 rounded-full bg-gold-50 text-gold-600 font-bold border border-gold-500/20">
                        {{ post.category }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <Calendar :size="13" />
                        {{ post.published_at }}
                    </span>
                    <span class="inline-flex items-center gap-1">
                        <User :size="13" />
                        {{ post.author_name }}
                    </span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-navy-950 leading-tight">
                    {{ post.title }}
                </h1>

                <p v-if="post.excerpt" class="mt-4 text-lg text-slate-600 leading-relaxed">
                    {{ post.excerpt }}
                </p>

                <img
                    v-if="post.featured_image"
                    :src="post.featured_image"
                    :alt="post.title"
                    class="w-full max-h-[460px] object-cover rounded-3xl mt-8 border border-slate-200"
                />

                <div class="mt-10 prose-carano" v-html="post.body" />

                <!-- Inline CTA Box (Bright & Airy) -->
                <div class="mt-12 p-7 rounded-3xl bg-ocean-50 border border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-5">
                    <div>
                        <div class="text-xs font-bold text-gold-600 uppercase tracking-wider">PT. CARANO UTAMA LOGISTIK</div>
                        <div class="text-xl font-extrabold text-navy-950 mt-1">
                            {{ locale === 'en' ? 'Need help planning your next import?' : 'Butuh bantuan merencanakan impor Anda berikutnya?' }}
                        </div>
                    </div>
                    <Link
                        href="/kontak"
                        class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-full bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shrink-0 shadow-sm transition"
                    >
                        <span>{{ locale === 'en' ? 'Consult Now' : 'Konsultasi Sekarang' }}</span>
                        <ArrowUpRight :size="16" />
                    </Link>
                </div>

                <!-- Related Posts -->
                <div v-if="relatedPosts.length" class="mt-16 pt-12 border-t border-slate-200">
                    <h2 class="text-xl font-extrabold text-navy-950 mb-6">
                        {{ locale === 'en' ? 'Related Articles' : 'Artikel Terkait Lainnya' }}
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        <Link
                            v-for="r in relatedPosts"
                            :key="r.id"
                            :href="`/insight/${r.slug}`"
                            class="p-5 rounded-2xl border border-slate-200 hover:border-navy-800/40 hover:shadow-md transition"
                        >
                            <div class="text-[11px] font-bold text-ocean-600 mb-1">{{ r.category }}</div>
                            <div class="text-sm font-extrabold text-navy-950 line-clamp-2">{{ r.title }}</div>
                        </Link>
                    </div>
                </div>
            </div>
        </article>
    </MainLayout>
</template>
