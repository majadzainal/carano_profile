<script setup>
import { ref } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { ExternalLink, Pencil, Plus, Search, Trash2 } from 'lucide-vue-next';

const props = defineProps({
    posts: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

const applyFilter = () => {
    router.get('/carano-admin/posts', { search: search.value, status: status.value }, { preserveState: true, replace: true });
};

const remove = (post) => {
    if (!confirm(`Hapus artikel "${post.title_id}"?`)) return;
    router.delete(`/carano-admin/posts/${post.id}`);
};
</script>

<template>
    <Head title="Artikel & Insight â€” CMS" />

    <AdminLayout title="Artikel & Insight (Blog)">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <div class="flex flex-wrap items-center gap-2">
                <div class="relative">
                    <Search :size="15" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input
                        v-model="search"
                        @keyup.enter="applyFilter"
                        type="text"
                        placeholder="Cari judul artikel..."
                        class="pl-9 pr-4 py-2 rounded-xl border border-slate-300 bg-white text-sm w-60"
                    />
                </div>
                <select v-model="status" @change="applyFilter" class="rounded-xl border border-slate-300 bg-white px-3 py-2 text-sm">
                    <option value="">Semua Status</option>
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>

            <Link
                href="/carano-admin/posts/create"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-xs shadow-sm transition"
            >
                <Plus :size="16" /> Tulis Artikel Baru
            </Link>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5">Judul Artikel</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Penulis</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="post in posts" :key="post.id" class="hover:bg-slate-50/70">
                        <td class="px-5 py-4 max-w-md">
                            <div class="font-bold text-navy-950">{{ post.title_id }}</div>
                            <div class="text-xs text-slate-400 font-mono truncate">/insight/{{ post.slug }}</div>
                        </td>
                        <td class="px-5 py-4">
                            <span class="px-2.5 py-1 rounded-full bg-ocean-50 text-ocean-600 text-xs font-bold">{{ post.category }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span
                                class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase"
                                :class="post.status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600'"
                            >
                                {{ post.status }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs text-slate-500">{{ post.author?.name || 'Admin' }}</td>
                        <td class="px-5 py-4 text-right space-x-2 whitespace-nowrap">
                            <a
                                v-if="post.status === 'published'"
                                :href="`/insight/${post.slug}`"
                                target="_blank"
                                class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg text-slate-500 hover:bg-slate-100 text-xs"
                                title="Lihat di website"
                            >
                                <ExternalLink :size="14" />
                            </a>
                            <Link
                                :href="`/carano-admin/posts/${post.id}/edit`"
                                class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-ocean-50 text-navy-900 text-xs font-bold"
                            >
                                <Pencil :size="13" /> Edit
                            </Link>
                            <button type="button" @click="remove(post)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 cursor-pointer">
                                <Trash2 :size="14" />
                            </button>
                        </td>
                    </tr>
                    <tr v-if="!posts.length">
                        <td colspan="5" class="px-5 py-10 text-center text-slate-400">Belum ada artikel.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AdminLayout>
</template>
