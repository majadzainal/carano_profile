<script setup>
import { computed, ref } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import {
    CheckCircle2,
    ExternalLink,
    FileText,
    HelpCircle,
    Image as ImageIcon,
    Inbox,
    LayoutDashboard,
    Layers,
    LogOut,
    Map,
    Menu,
    Route,
    Settings,
    Ship,
    Users,
    X,
    AlertCircle,
} from 'lucide-vue-next';

defineProps({
    title: { type: String, default: 'Dashboard' },
});

const page = usePage();
const user = computed(() => page.props.auth?.user);
const settings = computed(() => page.props.settings || {});
const currentPath = computed(() => page.props.currentPath || '/carano-admin');
const unreadCount = computed(() => page.props.unreadInquiriesCount || 0);
const flashSuccess = computed(() => page.props.flash?.success);
const flashError = computed(() => page.props.flash?.error);

const sidebarOpen = ref(false);

const menuGroups = computed(() => [
    {
        label: 'Utama',
        items: [
            { label: 'Dashboard', href: '/carano-admin', icon: LayoutDashboard, exact: true },
            { label: 'Inbox Penawaran', href: '/carano-admin/inquiries', icon: Inbox, badge: unreadCount.value },
        ],
    },
    {
        label: 'Kelola Konten (CMS)',
        items: [
            { label: 'Konten Halaman', href: '/carano-admin/sections', icon: Layers },
            { label: 'Road Map Shipment', href: '/carano-admin/roadmap', icon: Route },
            { label: 'Layanan Logistik', href: '/carano-admin/services', icon: Ship },
            { label: 'Jaringan Rute', href: '/carano-admin/routes', icon: Map },
            { label: 'Artikel & Insight', href: '/carano-admin/posts', icon: FileText },
            { label: 'FAQ', href: '/carano-admin/faqs', icon: HelpCircle },
            { label: 'Media Library', href: '/carano-admin/media', icon: ImageIcon },
        ],
    },
    {
        label: 'Sistem',
        items: [
            { label: 'Pengaturan Situs', href: '/carano-admin/settings', icon: Settings },
            { label: 'Pengguna CMS', href: '/carano-admin/users', icon: Users },
        ],
    },
]);

const isActive = (item) => {
    if (item.exact) return currentPath.value === item.href;
    return currentPath.value.startsWith(item.href);
};

const logout = () => {
    router.post('/carano-admin/logout');
};
</script>

<template>
    <div class="min-h-screen bg-slate-100 flex">
        <!-- Mobile Sidebar Backdrop -->
        <div
            v-if="sidebarOpen"
            @click="sidebarOpen = false"
            class="fixed inset-0 z-40 bg-navy-950/60 lg:hidden"
        />

        <!-- WordPress-inspired Deep Navy Sidebar -->
        <aside
            class="fixed lg:sticky top-0 left-0 z-50 h-screen w-64 bg-navy-950 text-slate-300 flex flex-col border-r border-white/10 transition-transform duration-200"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <!-- Brand Header -->
            <div class="h-16 px-4 flex items-center justify-between border-b border-white/10 shrink-0">
                <Link href="/carano-admin" class="flex items-center gap-2.5">
                    <img
                        :src="settings.logo_dark || '/images/brand/logo-carano-dark.png'"
                        alt="Carano"
                        class="h-10 w-10 object-contain"
                    />
                    <div class="leading-tight">
                        <div class="text-sm font-extrabold text-white">CARANO CMS</div>
                        <div class="text-[10px] font-semibold text-gold-400 uppercase tracking-wider">Content Manager</div>
                    </div>
                </Link>
                <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white">
                    <X :size="20" />
                </button>
            </div>

            <!-- Menu List -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-5">
                <div v-for="group in menuGroups" :key="group.label">
                    <div class="px-3 mb-2 text-[10px] font-bold uppercase tracking-widest text-slate-500">
                        {{ group.label }}
                    </div>
                    <div class="space-y-1">
                        <Link
                            v-for="item in group.items"
                            :key="item.href"
                            :href="item.href"
                            @click="sidebarOpen = false"
                            class="flex items-center justify-between gap-2.5 px-3 py-2.5 rounded-xl text-sm font-medium transition"
                            :class="
                                isActive(item)
                                    ? 'bg-gold-500 text-navy-950 font-bold shadow-sm'
                                    : 'text-slate-300 hover:bg-white/5 hover:text-white'
                            "
                        >
                            <span class="flex items-center gap-2.5">
                                <component :is="item.icon" :size="17" />
                                <span>{{ item.label }}</span>
                            </span>
                            <span
                                v-if="item.badge"
                                class="px-2 py-0.5 rounded-full text-[11px] font-extrabold"
                                :class="isActive(item) ? 'bg-navy-950 text-gold-400' : 'bg-rose-500 text-white'"
                            >
                                {{ item.badge }}
                            </span>
                        </Link>
                    </div>
                </div>
            </nav>

            <!-- Footer User Info -->
            <div class="p-3 border-t border-white/10 shrink-0">
                <div class="px-3 py-2 rounded-xl bg-white/5 flex items-center justify-between gap-2">
                    <div class="min-w-0">
                        <div class="text-xs font-bold text-white truncate">{{ user?.name }}</div>
                        <div class="text-[11px] text-slate-400 truncate">{{ user?.email }}</div>
                    </div>
                    <button
                        type="button"
                        @click="logout"
                        title="Keluar"
                        class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-white/5 transition cursor-pointer"
                    >
                        <LogOut :size="16" />
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Top Admin Bar -->
            <header class="sticky top-0 z-30 h-16 bg-white border-b border-slate-200 px-4 sm:px-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100"
                    >
                        <Menu :size="20" />
                    </button>
                    <h1 class="text-lg font-extrabold text-navy-950 truncate">{{ title }}</h1>
                </div>

                <div class="flex items-center gap-3">
                    <a
                        href="/"
                        target="_blank"
                        class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-bold text-navy-900 bg-ocean-50 hover:bg-ocean-100 border border-slate-200 transition"
                    >
                        <span>Lihat Website</span>
                        <ExternalLink :size="14" />
                    </a>
                </div>
            </header>

            <!-- Flash Messages -->
            <div v-if="flashSuccess || flashError" class="px-4 sm:px-6 pt-4">
                <div
                    v-if="flashSuccess"
                    class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-medium flex items-center gap-2.5"
                >
                    <CheckCircle2 :size="18" class="text-emerald-600 shrink-0" />
                    <span>{{ flashSuccess }}</span>
                </div>
                <div
                    v-if="flashError"
                    class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-medium flex items-center gap-2.5"
                >
                    <AlertCircle :size="18" class="text-rose-600 shrink-0" />
                    <span>{{ flashError }}</span>
                </div>
            </div>

            <!-- Slot Content -->
            <main class="flex-1 p-4 sm:p-6">
                <slot />
            </main>
        </div>
    </div>
</template>
