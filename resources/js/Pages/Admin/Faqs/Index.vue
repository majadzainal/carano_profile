<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Pencil, Plus, Save, Trash2, X } from 'lucide-vue-next';

defineProps({
    faqs: { type: Array, default: () => [] },
});

const editingId = ref(null);
const showForm = ref(false);

const form = useForm({
    question_id: '',
    question_en: '',
    answer_id: '',
    answer_en: '',
    category: 'Umum',
    sort_order: 1,
    is_active: true,
});

const openCreate = (next) => {
    editingId.value = null;
    form.reset();
    form.category = 'Layanan';
    form.sort_order = next;
    form.is_active = true;
    showForm.value = true;
};

const openEdit = (faq) => {
    editingId.value = faq.id;
    Object.assign(form, {
        question_id: faq.question_id,
        question_en: faq.question_en || '',
        answer_id: faq.answer_id,
        answer_en: faq.answer_en || '',
        category: faq.category || 'Umum',
        sort_order: faq.sort_order || 0,
        is_active: Boolean(faq.is_active),
    });
    showForm.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/carano-admin/faqs/${editingId.value}`, { onSuccess: () => (showForm.value = false) });
    } else {
        form.post('/carano-admin/faqs', { onSuccess: () => (showForm.value = false) });
    }
};

const remove = (faq) => {
    if (!confirm(`Hapus FAQ "${faq.question_id}"?`)) return;
    router.delete(`/carano-admin/faqs/${faq.id}`);
};
</script>

<template>
    <Head title="Kelola FAQ — CMS" />

    <AdminLayout title="Kelola FAQ">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <p class="text-sm text-slate-600">Kelola pertanyaan yang sering diajukan pengunjung website.</p>
            <button type="button" @click="openCreate(faqs.length + 1)" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-xs cursor-pointer">
                <Plus :size="16" /> Tambah FAQ
            </button>
        </div>

        <div class="space-y-3">
            <div v-for="faq in faqs" :key="faq.id" class="bg-white rounded-2xl border border-slate-200 p-5 flex items-start justify-between gap-4">
                <div>
                    <span class="px-2.5 py-0.5 rounded-full bg-ocean-50 text-ocean-600 text-[10px] font-bold uppercase">{{ faq.category }}</span>
                    <h3 class="font-bold text-navy-950 mt-1.5">{{ faq.question_id }}</h3>
                    <p class="text-xs text-slate-600 mt-1 leading-relaxed">{{ faq.answer_id }}</p>
                </div>
                <div class="flex gap-2 shrink-0">
                    <button type="button" @click="openEdit(faq)" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-ocean-50 text-navy-900 text-xs font-bold cursor-pointer">
                        <Pencil :size="13" /> Edit
                    </button>
                    <button type="button" @click="remove(faq)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 cursor-pointer">
                        <Trash2 :size="14" />
                    </button>
                </div>
            </div>
        </div>

        <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/70 p-4">
            <div class="bg-white rounded-3xl w-full max-w-2xl max-h-[90vh] overflow-y-auto p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-extrabold text-navy-950">{{ editingId ? 'Edit FAQ' : 'Tambah FAQ' }}</h3>
                    <button @click="showForm = false" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 cursor-pointer"><X :size="20" /></button>
                </div>
                <form @submit.prevent="submit" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Kategori</label>
                            <input v-model="form.category" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Urutan</label>
                            <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Pertanyaan (ID) *</label>
                        <input v-model="form.question_id" type="text" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Jawaban (ID) *</label>
                        <textarea v-model="form.answer_id" rows="3" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Question (EN)</label>
                        <input v-model="form.question_en" type="text" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Answer (EN)</label>
                        <textarea v-model="form.answer_en" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
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
