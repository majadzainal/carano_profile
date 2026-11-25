<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import IconMapper from '@/Components/IconMapper.vue';
import { Pencil, Plus, Save, Trash2, X } from 'lucide-vue-next';

defineProps({
    steps: { type: Array, default: () => [] },
});

const icons = ['factory', 'truck', 'anchor', 'file-check', 'container', 'ship', 'radar', 'arrow-down-circle', 'shield-check', 'map-pin-check', 'plane', 'globe', 'package'];

const editingId = ref(null);
const showForm = ref(false);
const highlightsIdText = ref('');
const highlightsEnText = ref('');

const form = useForm({
    step_number: 1,
    phase: 'origin',
    title_id: '',
    title_en: '',
    description_id: '',
    description_en: '',
    highlights_id: [],
    highlights_en: [],
    icon: 'ship',
    is_active: true,
});

const openCreate = (nextNum) => {
    editingId.value = null;
    form.reset();
    form.step_number = nextNum;
    form.phase = 'origin';
    form.icon = 'ship';
    form.is_active = true;
    highlightsIdText.value = '';
    highlightsEnText.value = '';
    showForm.value = true;
};

const openEdit = (step) => {
    editingId.value = step.id;
    form.step_number = step.step_number;
    form.phase = step.phase;
    form.title_id = step.title_id;
    form.title_en = step.title_en;
    form.description_id = step.description_id || '';
    form.description_en = step.description_en || '';
    form.icon = step.icon || 'ship';
    form.is_active = Boolean(step.is_active);
    highlightsIdText.value = (step.highlights_id || []).join('\n');
    highlightsEnText.value = (step.highlights_en || []).join('\n');
    showForm.value = true;
};

const submit = () => {
    form.highlights_id = highlightsIdText.value.split('\n').map((s) => s.trim()).filter(Boolean);
    form.highlights_en = highlightsEnText.value.split('\n').map((s) => s.trim()).filter(Boolean);

    if (editingId.value) {
        form.put(`/carano-admin/roadmap/${editingId.value}`, {
            onSuccess: () => (showForm.value = false),
        });
    } else {
        form.post('/carano-admin/roadmap', {
            onSuccess: () => (showForm.value = false),
        });
    }
};

const remove = (step) => {
    if (!confirm(`Hapus Tahap #${step.step_number}: ${step.title_id}?`)) return;
    router.delete(`/carano-admin/roadmap/${step.id}`);
};
</script>

<template>
    <Head title="Kelola Road Map Shipment — CMS" />

    <AdminLayout title="Road Map Shipment (10 Tahap)">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <p class="text-sm text-slate-600">Atur tahapan pengiriman interaktif yang tampil di Homepage dan halaman Road Map.</p>
            <button
                type="button"
                @click="openCreate(steps.length + 1)"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-xs shadow-sm cursor-pointer"
            >
                <Plus :size="16" />
                Tambah Tahap
            </button>
        </div>

        <div class="space-y-3">
            <div
                v-for="step in steps"
                :key="step.id"
                class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4"
            >
                <div class="flex items-start gap-4">
                    <div class="w-11 h-11 rounded-xl bg-navy-900 text-gold-400 font-extrabold text-sm flex items-center justify-center shrink-0">
                        {{ String(step.step_number).padStart(2, '0') }}
                    </div>
                    <div>
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase bg-ocean-50 text-ocean-600">
                                {{ step.phase }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs text-slate-400">
                                <IconMapper :name="step.icon" :size="13" />
                                {{ step.icon }}
                            </span>
                        </div>
                        <h3 class="font-extrabold text-navy-950 text-sm sm:text-base">{{ step.title_id }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ step.description_id }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <button
                        type="button"
                        @click="openEdit(step)"
                        class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-ocean-50 hover:bg-ocean-100 text-navy-900 text-xs font-bold cursor-pointer"
                    >
                        <Pencil :size="14" /> Edit
                    </button>
                    <button
                        type="button"
                        @click="remove(step)"
                        class="p-2 rounded-xl text-rose-600 hover:bg-rose-50 cursor-pointer"
                    >
                        <Trash2 :size="15" />
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Form -->
        <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/70 p-4">
            <div class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] overflow-y-auto p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-extrabold text-navy-950">
                        {{ editingId ? 'Edit Tahapan Road Map' : 'Tambah Tahapan Baru' }}
                    </h3>
                    <button @click="showForm = false" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 cursor-pointer">
                        <X :size="20" />
                    </button>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Nomor Tahap</label>
                            <input v-model.number="form.step_number" type="number" min="1" required class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Fase</label>
                            <select v-model="form.phase" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm bg-white">
                                <option value="origin">Origin (Negara Asal)</option>
                                <option value="sea">Sea (Perjalanan Laut)</option>
                                <option value="destination">Destination (Pelabuhan RI & Delivery)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Ikon</label>
                            <select v-model="form.icon" class="w-full rounded-xl border border-slate-300 px-3 py-2.5 text-sm bg-white">
                                <option v-for="ic in icons" :key="ic" :value="ic">{{ ic }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Judul (Indonesia) *</label>
                            <input v-model="form.title_id" type="text" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Title (English) *</label>
                            <input v-model="form.title_en" type="text" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Deskripsi (ID)</label>
                            <textarea v-model="form.description_id" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Description (EN)</label>
                            <textarea v-model="form.description_en" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Poin Utama (ID — 1 baris per poin)</label>
                            <textarea v-model="highlightsIdText" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Highlights (EN — 1 line per item)</label>
                            <textarea v-model="highlightsEnText" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs" />
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
