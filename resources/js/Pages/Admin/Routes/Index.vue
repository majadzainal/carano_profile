<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Pencil, Plus, Save, Trash2, X } from 'lucide-vue-next';

defineProps({
    hubs: { type: Array, default: () => [] },
});

const editingId = ref(null);
const showForm = ref(false);

const form = useForm({
    type: 'origin',
    code: '',
    name_id: '',
    name_en: '',
    country: '',
    description_id: '',
    description_en: '',
    map_x: 500,
    map_y: 250,
    sort_order: 1,
    is_active: true,
});

const openCreate = () => {
    editingId.value = null;
    form.reset();
    form.type = 'origin';
    form.map_x = 500;
    form.map_y = 250;
    form.is_active = true;
    showForm.value = true;
};

const openEdit = (hub) => {
    editingId.value = hub.id;
    Object.assign(form, {
        type: hub.type,
        code: hub.code || '',
        name_id: hub.name_id,
        name_en: hub.name_en,
        country: hub.country,
        description_id: hub.description_id || '',
        description_en: hub.description_en || '',
        map_x: hub.map_x,
        map_y: hub.map_y,
        sort_order: hub.sort_order || 0,
        is_active: Boolean(hub.is_active),
    });
    showForm.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/carano-admin/routes/${editingId.value}`, { onSuccess: () => (showForm.value = false) });
    } else {
        form.post('/carano-admin/routes', { onSuccess: () => (showForm.value = false) });
    }
};

const remove = (hub) => {
    if (!confirm(`Hapus hub "${hub.name_id}"?`)) return;
    router.delete(`/carano-admin/routes/${hub.id}`);
};
</script>

<template>
    <Head title="Kelola Jaringan Rute â€” CMS" />

    <AdminLayout title="Jaringan Rute & Pelabuhan">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <p class="text-sm text-slate-600">Kelola negara asal dan pelabuhan tujuan Indonesia yang tampil pada Peta Rute Maritim Interaktif.</p>
            <button type="button" @click="openCreate" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-xs cursor-pointer">
                <Plus :size="16" /> Tambah Hub / Pelabuhan
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5">Tipe</th>
                        <th class="px-5 py-3.5">Nama Hub / Pelabuhan</th>
                        <th class="px-5 py-3.5">Kode</th>
                        <th class="px-5 py-3.5">Koordinat Peta (X, Y)</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="h in hubs" :key="h.id" class="hover:bg-slate-50/70">
                        <td class="px-5 py-3.5">
                            <span
                                class="px-2.5 py-1 rounded-full text-[11px] font-bold uppercase"
                                :class="h.type === 'origin' ? 'bg-gold-100 text-navy-900' : 'bg-sky-100 text-navy-900'"
                            >
                                {{ h.type === 'origin' ? 'Negara Asal' : 'Pelabuhan RI' }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="font-bold text-navy-950">{{ h.name_id }}</div>
                            <div class="text-xs text-slate-500">{{ h.country }}</div>
                        </td>
                        <td class="px-5 py-3.5 font-mono text-xs text-ocean-600 font-bold">{{ h.code }}</td>
                        <td class="px-5 py-3.5 font-mono text-xs text-slate-500">{{ h.map_x }}, {{ h.map_y }}</td>
                        <td class="px-5 py-3.5 text-right space-x-2">
                            <button type="button" @click="openEdit(h)" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-ocean-50 text-navy-900 text-xs font-bold cursor-pointer">
                                <Pencil :size="13" /> Edit
                            </button>
                            <button type="button" @click="remove(h)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 cursor-pointer">
                                <Trash2 :size="14" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/70 p-4">
            <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-extrabold text-navy-950">{{ editingId ? 'Edit Hub Rute' : 'Tambah Hub Baru' }}</h3>
                    <button @click="showForm = false" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 cursor-pointer"><X :size="20" /></button>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Tipe</label>
                            <select v-model="form.type" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white">
                                <option value="origin">Negara Asal (Origin)</option>
                                <option value="destination">Pelabuhan Tujuan RI</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Kode (mis. JP / IDJKT)</label>
                            <input v-model="form.code" type="text" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Negara / Kota *</label>
                            <input v-model="form.country" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Nama (ID) *</label>
                            <input v-model="form.name_id" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Name (EN) *</label>
                            <input v-model="form.name_en" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Deskripsi (ID)</label>
                            <textarea v-model="form.description_id" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Description (EN)</label>
                            <textarea v-model="form.description_en" rows="3" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Posisi Peta X (0-1000)</label>
                            <input v-model.number="form.map_x" type="number" min="0" max="1000" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Posisi Peta Y (0-600)</label>
                            <input v-model.number="form.map_y" type="number" min="0" max="600" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Urutan</label>
                            <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold">
                            <input v-model="form.is_active" type="checkbox" class="rounded" /> Aktif
                        </label>
                        <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-navy-900 text-white font-bold text-sm cursor-pointer">
                            <Save :size="15" /> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
