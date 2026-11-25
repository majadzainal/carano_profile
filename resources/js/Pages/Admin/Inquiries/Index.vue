<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Download, MessageCircle, Save, Trash2 } from 'lucide-vue-next';

const props = defineProps({
    inquiries: { type: Array, default: () => [] },
    filters: { type: Object, default: () => ({}) },
});

const statusFilter = ref(props.filters.status || '');
const selected = ref(props.inquiries[0] || null);

const form = useForm({
    status: 'new',
    admin_notes: '',
});

const selectInquiry = (inq) => {
    selected.value = inq;
    form.status = inq.status;
    form.admin_notes = inq.admin_notes || '';
};

if (selected.value) selectInquiry(selected.value);

const applyFilter = () => {
    router.get('/carano-admin/inquiries', { status: statusFilter.value }, { preserveState: true, replace: true });
};

const updateInquiry = () => {
    if (!selected.value) return;
    form.put(`/carano-admin/inquiries/${selected.value.id}`, { preserveScroll: true });
};

const remove = (inq) => {
    if (!confirm(`Hapus pesan dari ${inq.company_name}?`)) return;
    router.delete(`/carano-admin/inquiries/${inq.id}`, {
        onSuccess: () => (selected.value = null),
    });
};

const waReplyUrl = (inq) => {
    const clean = (inq.phone || '').replace(/[^0-9]/g, '');
    const intl = clean.startsWith('0') ? '62' + clean.slice(1) : clean;
    const msg = `Halo Bapak/Ibu ${inq.contact_name} dari ${inq.company_name}, kami dari PT. CARANO UTAMA LOGISTIK menindaklanjuti permintaan penawaran rute ${inq.origin_country} ke ${inq.destination_port}.`;
    return `https://wa.me/${intl}?text=${encodeURIComponent(msg)}`;
};

const statusBadge = (s) => ({
    new: 'bg-rose-100 text-rose-700',
    in_progress: 'bg-amber-100 text-amber-800',
    quoted: 'bg-sky-100 text-sky-700',
    closed: 'bg-emerald-100 text-emerald-700',
}[s] || 'bg-slate-100 text-slate-600');
</script>

<template>
    <Head title="Inbox Penawaran (RFQ) — CMS" />

    <AdminLayout title="Inbox Penawaran (RFQ Leads)">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <select v-model="statusFilter" @change="applyFilter" class="rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm">
                <option value="">Semua Status</option>
                <option value="new">Baru (New)</option>
                <option value="in_progress">Diproses (In Progress)</option>
                <option value="quoted">Sudah Dikirim Penawaran (Quoted)</option>
                <option value="closed">Selesai (Closed)</option>
            </select>

            <a
                href="/carano-admin/inquiries/export"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-navy-900 hover:bg-navy-800 text-white text-xs font-bold transition"
            >
                <Download :size="15" class="text-gold-400" /> Export CSV
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- List -->
            <div class="lg:col-span-5 space-y-2.5">
                <button
                    v-for="inq in inquiries"
                    :key="inq.id"
                    type="button"
                    @click="selectInquiry(inq)"
                    class="w-full text-left p-4 rounded-2xl border transition cursor-pointer"
                    :class="selected?.id === inq.id ? 'bg-navy-900 text-white border-navy-900 shadow-md' : 'bg-white border-slate-200 hover:border-ocean-500'"
                >
                    <div class="flex items-center justify-between gap-2 mb-1">
                        <span class="font-bold text-sm truncate">{{ inq.company_name }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase" :class="statusBadge(inq.status)">
                            {{ inq.status }}
                        </span>
                    </div>
                    <div class="text-xs" :class="selected?.id === inq.id ? 'text-gold-400' : 'text-ocean-600'">
                        {{ inq.origin_country }} → {{ inq.destination_port }}
                    </div>
                    <div class="text-xs mt-1 truncate" :class="selected?.id === inq.id ? 'text-slate-300' : 'text-slate-500'">
                        {{ inq.contact_name }} • {{ inq.phone }}
                    </div>
                </button>
                <div v-if="!inquiries.length" class="p-8 bg-white rounded-2xl border border-slate-200 text-center text-sm text-slate-400">
                    Belum ada permintaan penawaran.
                </div>
            </div>

            <!-- Detail Inspector -->
            <div v-if="selected" class="lg:col-span-7 bg-white rounded-3xl border border-slate-200 p-6 sm:p-7 space-y-6">
                <div class="flex flex-wrap items-start justify-between gap-4 pb-5 border-b border-slate-100">
                    <div>
                        <h2 class="text-xl font-extrabold text-navy-950">{{ selected.company_name }}</h2>
                        <div class="text-sm text-slate-600 mt-1">{{ selected.contact_name }} • {{ selected.email }} • {{ selected.phone }}</div>
                    </div>
                    <div class="flex gap-2">
                        <a
                            :href="waReplyUrl(selected)"
                            target="_blank"
                            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs font-bold"
                        >
                            <MessageCircle :size="14" /> Balas WA
                        </a>
                        <button type="button" @click="remove(selected)" class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 cursor-pointer">
                            <Trash2 :size="16" />
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-ocean-50 p-4 rounded-2xl text-xs">
                    <div>
                        <div class="text-slate-400 font-bold uppercase">Negara Asal</div>
                        <div class="font-extrabold text-navy-950 mt-0.5">{{ selected.origin_country || '-' }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-bold uppercase">Pelabuhan Tujuan</div>
                        <div class="font-extrabold text-navy-950 mt-0.5">{{ selected.destination_port || '-' }}</div>
                    </div>
                    <div>
                        <div class="text-slate-400 font-bold uppercase">Layanan</div>
                        <div class="font-extrabold text-navy-950 mt-0.5">{{ selected.service_type || '-' }}</div>
                    </div>
                </div>

                <div>
                    <div class="text-xs font-bold uppercase text-slate-400 mb-1.5">Detail Kargo & Pesan</div>
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-sm text-slate-700 leading-relaxed whitespace-pre-line">
                        {{ selected.cargo_details }}
                    </div>
                </div>

                <form @submit.prevent="updateInquiry" class="pt-4 border-t border-slate-100 space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Status Tindak Lanjut</label>
                        <select v-model="form.status" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white">
                            <option value="new">Baru (New)</option>
                            <option value="in_progress">Sedang Diproses</option>
                            <option value="quoted">Penawaran Terkirim</option>
                            <option value="closed">Selesai</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Catatan Internal Tim Sales</label>
                        <textarea v-model="form.admin_notes" rows="3" placeholder="Catat progres penawaran atau harga yang dikirim..." class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                    <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm cursor-pointer">
                        <Save :size="15" /> Simpan Status
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
