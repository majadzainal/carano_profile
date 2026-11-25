<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import {
    ArrowUpRight,
    FileText,
    Image as ImageIcon,
    Inbox,
    Layers,
    Plus,
    Route,
    Ship,
} from 'lucide-vue-next';

defineProps({
    stats: { type: Object, required: true },
    recentInquiries: { type: Array, default: () => [] },
    recentPosts: { type: Array, default: () => [] },
});

const statusBadge = (status) => {
    const map = {
        new: 'bg-rose-100 text-rose-700',
        in_progress: 'bg-amber-100 text-amber-800',
        quoted: 'bg-sky-100 text-sky-700',
        closed: 'bg-emerald-100 text-emerald-700',
    };
    return map[status] || 'bg-slate-100 text-slate-700';
};
</script>

<template>
    <Head title="Dashboard CMS" />

    <AdminLayout title="Dashboard CMS">
        <!-- Quick Action Banner (WordPress Welcome Style) -->
        <div class="rounded-3xl bg-gradient-to-r from-navy-950 via-navy-900 to-navy-800 text-white p-6 sm:p-8 mb-6 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div>
                <div class="text-xs font-bold uppercase tracking-wider text-gold-400">PT. CARANO UTAMA LOGISTIK — CMS</div>
                <h2 class="text-2xl font-extrabold mt-1">Kelola Seluruh Konten Website dengan Mudah</h2>
                <p class="text-sm text-slate-300 mt-1.5 max-w-2xl">
                    Edit teks halaman, 10 tahapan Road Map Shipment, layanan, peta rute, artikel blog, hingga brosur PDF secara langsung tanpa mengubah kode.
                </p>
            </div>
            <div class="flex flex-wrap gap-2.5 shrink-0">
                <Link
                    href="/carano-admin/posts/create"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 text-xs font-extrabold transition"
                >
                    <Plus :size="15" />
                    Tulis Artikel Baru
                </Link>
                <Link
                    href="/carano-admin/sections"
                    class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-white border border-white/15 text-xs font-bold transition"
                >
                    <Layers :size="15" />
                    Edit Konten Halaman
                </Link>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <Link href="/carano-admin/inquiries" class="bg-white rounded-2xl p-5 border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase">
                    <span>RFQ Baru</span>
                    <Inbox :size="18" class="text-rose-500" />
                </div>
                <div class="text-3xl font-extrabold text-navy-950 mt-2">{{ stats.new_inquiries }}</div>
                <div class="text-xs text-slate-400 mt-1">Dari total {{ stats.total_inquiries }} penawaran</div>
            </Link>

            <Link href="/carano-admin/posts" class="bg-white rounded-2xl p-5 border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase">
                    <span>Artikel Terbit</span>
                    <FileText :size="18" class="text-ocean-600" />
                </div>
                <div class="text-3xl font-extrabold text-navy-950 mt-2">{{ stats.published_posts }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ stats.draft_posts }} draft tersimpan</div>
            </Link>

            <Link href="/carano-admin/roadmap" class="bg-white rounded-2xl p-5 border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase">
                    <span>Tahap Road Map</span>
                    <Route :size="18" class="text-gold-600" />
                </div>
                <div class="text-3xl font-extrabold text-navy-950 mt-2">{{ stats.roadmap_steps }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ stats.active_services }} layanan aktif {{ stats.trade_hubs }} hub rute</div>
            </Link>

            <Link href="/carano-admin/media" class="bg-white rounded-2xl p-5 border border-slate-200 hover:shadow-md transition">
                <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase">
                    <span>Media Library</span>
                    <ImageIcon :size="18" class="text-emerald-600" />
                </div>
                <div class="text-3xl font-extrabold text-navy-950 mt-2">{{ stats.media_files }}</div>
                <div class="text-xs text-slate-400 mt-1">{{ stats.sections }} blok konten halaman</div>
            </Link>
        </div>

        <!-- Recent Inquiries & Recent Posts -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <div class="lg:col-span-7 bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-navy-950">Permintaan Penawaran (RFQ) Terbaru</h3>
                    <Link href="/carano-admin/inquiries" class="text-xs font-bold text-ocean-600 hover:text-navy-900 inline-flex items-center gap-1">
                        Lihat Semua <ArrowUpRight :size="14" />
                    </Link>
                </div>
                <div class="divide-y divide-slate-100">
                    <div v-for="inq in recentInquiries" :key="inq.id" class="p-4 hover:bg-slate-50/70 transition">
                        <div class="flex items-center justify-between gap-2">
                            <div class="font-bold text-sm text-navy-950">{{ inq.company_name }}</div>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase" :class="statusBadge(inq.status)">
                                {{ inq.status }}
                            </span>
                        </div>
                        <div class="text-xs text-slate-500 mt-0.5">
                            {{ inq.contact_name }} • {{ inq.origin_country }} → {{ inq.destination_port }}
                        </div>
                        <p class="text-xs text-slate-600 mt-1.5 line-clamp-2">{{ inq.cargo_details }}</p>
                    </div>
                    <div v-if="!recentInquiries.length" class="p-8 text-center text-sm text-slate-400">
                        Belum ada permintaan penawaran masuk.
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 bg-white rounded-2xl border border-slate-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-sm font-extrabold text-navy-950">Artikel & Insight Terbaru</h3>
                    <Link href="/carano-admin/posts" class="text-xs font-bold text-ocean-600 hover:text-navy-900 inline-flex items-center gap-1">
                        Kelola <ArrowUpRight :size="14" />
                    </Link>
                </div>
                <div class="divide-y divide-slate-100">
                    <Link
                        v-for="p in recentPosts"
                        :key="p.id"
                        :href="`/carano-admin/posts/${p.id}/edit`"
                        class="block p-4 hover:bg-slate-50 transition"
                    >
                        <div class="flex items-center justify-between gap-2 mb-1">
                            <span class="text-[11px] font-bold text-ocean-600">{{ p.category }}</span>
                            <span
                                class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                                :class="p.status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600'"
                            >
                                {{ p.status }}
                            </span>
                        </div>
                        <div class="text-sm font-bold text-navy-950 line-clamp-1">{{ p.title_id }}</div>
                    </Link>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
