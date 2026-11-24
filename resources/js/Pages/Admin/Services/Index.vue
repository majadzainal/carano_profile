<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichTextEditor from '@/Components/Admin/RichTextEditor.vue';
import MediaPickerModal from '@/Components/Admin/MediaPickerModal.vue';
import IconMapper from '@/Components/IconMapper.vue';
import { Image as ImageIcon, Pencil, Plus, Save, Trash2, X } from 'lucide-vue-next';

defineProps({
    services: { type: Array, default: () => [] },
});

const icons = ['ship', 'truck', 'plane', 'shield-check', 'file-check', 'container', 'anchor', 'factory', 'globe', 'package'];
const editingId = ref(null);
const showForm = ref(false);
const showMedia = ref(false);
const langTab = ref('id');
const featuresIdText = ref('');
const featuresEnText = ref('');

const form = useForm({
    slug: '',
    badge_id: '',
    badge_en: '',
    title_id: '',
    title_en: '',
    short_desc_id: '',
    short_desc_en: '',
    body_id: '',
    body_en: '',
    icon: 'ship',
    image_path: '',
    features_id: [],
    features_en: [],
    sort_order: 1,
    is_active: true,
});

const openCreate = (nextOrder) => {
    editingId.value = null;
    form.reset();
    form.sort_order = nextOrder;
    form.icon = 'ship';
    form.is_active = true;
    featuresIdText.value = '';
    featuresEnText.value = '';
    langTab.value = 'id';
    showForm.value = true;
};

const openEdit = (svc) => {
    editingId.value = svc.id;
    form.slug = svc.slug;
    form.badge_id = svc.badge_id || '';
    form.badge_en = svc.badge_en || '';
    form.title_id = svc.title_id;
    form.title_en = svc.title_en;
    form.short_desc_id = svc.short_desc_id || '';
    form.short_desc_en = svc.short_desc_en || '';
    form.body_id = svc.body_id || '';
    form.body_en = svc.body_en || '';
    form.icon = svc.icon || 'ship';
    form.image_path = svc.image_path || '';
    form.sort_order = svc.sort_order || 0;
    form.is_active = Boolean(svc.is_active);
    featuresIdText.value = (svc.features_id || []).join('\n');
    featuresEnText.value = (svc.features_en || []).join('\n');
    langTab.value = 'id';
    showForm.value = true;
};

const submit = () => {
    form.features_id = featuresIdText.value.split('\n').map((s) => s.trim()).filter(Boolean);
    form.features_en = featuresEnText.value.split('\n').map((s) => s.trim()).filter(Boolean);
    if (editingId.value) {
        form.put(`/carano-admin/services/${editingId.value}`, { onSuccess: () => (showForm.value = false) });
    } else {
        form.post('/carano-admin/services', { onSuccess: () => (showForm.value = false) });
    }
};

const remove = (svc) => {
    if (!confirm(`Hapus layanan "${svc.title_id}"?`)) return;
    router.delete(`/carano-admin/services/${svc.id}`);
};
</script>

<template>
    <Head title="Kelola Layanan â€” CMS" />

    <AdminLayout title="Layanan Logistik">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <p class="text-sm text-slate-600">Kelola pilar layanan yang ditampilkan di Homepage dan halaman /layanan.</p>
            <button
                type="button"
                @click="openCreate(services.length + 1)"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-xs shadow-sm cursor-pointer"
            >
                <Plus :size="16" /> Tambah Layanan
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div v-for="svc in services" :key="svc.id" class="bg-white rounded-2xl border border-slate-200 p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <div class="flex items-center gap-2.5">
                            <span class="w-9 h-9 rounded-xl bg-ocean-50 text-navy-900 flex items-center justify-center">
                                <IconMapper :name="svc.icon" :size="18" />
                            </span>
                            <span class="text-xs font-bold uppercase text-gold-600">{{ svc.badge_id }}</span>
                        </div>
                        <span class="text-xs text-slate-400 font-mono">/{{ svc.slug }}</span>
                    </div>
                    <h3 class="font-extrabold text-navy-950 text-base">{{ svc.title_id }}</h3>
                    <p class="text-xs text-slate-500 mt-1.5 line-clamp-2">{{ svc.short_desc_id }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-[11px] font-bold" :class="svc.is_active ? 'text-emerald-600' : 'text-slate-400'">
                        {{ svc.is_active ? 'Aktif' : 'Nonaktif' }} â€¢ Urutan #{{ svc.sort_order }}
                    </span>
                    <div class="flex gap-2">
                        <button type="button" @click="openEdit(svc)" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-ocean-50 text-navy-900 text-xs font-bold cursor-pointer">
                            <Pencil :size="13" /> Edit
                        </button>
                        <button type="button" @click="remove(svc)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 cursor-pointer">
                            <Trash2 :size="14" />
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/70 p-4">
            <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] overflow-y-auto p-6 sm:p-8 shadow-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-extrabold text-navy-950">{{ editingId ? 'Edit Layanan' : 'Tambah Layanan Baru' }}</h3>
                    <button @click="showForm = false" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 cursor-pointer"><X :size="20" /></button>
                </div>

                <div class="flex gap-2 bg-slate-100 p-1 rounded-xl w-fit mb-5">
                    <button type="button" @click="langTab = 'id'" class="px-3.5 py-1.5 rounded-lg text-xs font-bold cursor-pointer" :class="langTab === 'id' ? 'bg-navy-900 text-white' : 'text-slate-600'">Indonesia (ID)</button>
                    <button type="button" @click="langTab = 'en'" class="px-3.5 py-1.5 rounded-lg text-xs font-bold cursor-pointer" :class="langTab === 'en' ? 'bg-navy-900 text-white' : 'text-slate-600'">English (EN)</button>
                </div>

                <form @submit.prevent="submit" class="space-y-4">
                    <div v-show="langTab === 'id'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Judul Layanan (ID) *</label>
                                <input v-model="form.title_id" type="text" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Badge (ID)</label>
                                <input v-model="form.badge_id" type="text" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Ringkasan Singkat (ID)</label>
                            <textarea v-model="form.short_desc_id" rows="2" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Daftar Keunggulan (ID â€” 1 baris per poin)</label>
                            <textarea v-model="featuresIdText" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Konten Detail Layanan (WYSIWYG â€” ID)</label>
                            <RichTextEditor v-model="form.body_id" />
                        </div>
                    </div>

                    <div v-show="langTab === 'en'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Service Title (EN) *</label>
                                <input v-model="form.title_en" type="text" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Badge (EN)</label>
                                <input v-model="form.badge_en" type="text" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Short Description (EN)</label>
                            <textarea v-model="form.short_desc_en" rows="2" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Features (EN â€” 1 line per item)</label>
                            <textarea v-model="featuresEnText" rows="3" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-xs" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Full Content (WYSIWYG â€” EN)</label>
                            <RichTextEditor v-model="form.body_en" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-3 border-t border-slate-100">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Slug URL</label>
                            <input v-model="form.slug" type="text" placeholder="otomatis-dari-judul" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Ikon</label>
                            <select v-model="form.icon" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white">
                                <option v-for="ic in icons" :key="ic" :value="ic">{{ ic }}</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Urutan</label>
                            <input v-model.number="form.sort_order" type="number" min="0" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Gambar Layanan (Opsional)</label>
                        <div class="flex gap-2">
                            <input v-model="form.image_path" type="text" class="flex-1 rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                            <button type="button" @click="showMedia = true" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-ocean-50 text-navy-900 text-xs font-bold border border-slate-200 cursor-pointer">
                                <ImageIcon :size="14" /> Media
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold">
                            <input v-model="form.is_active" type="checkbox" class="rounded" /> Aktif
                        </label>
                        <button type="submit" :disabled="form.processing" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-navy-900 text-white font-bold text-sm cursor-pointer">
                            <Save :size="15" /> Simpan Layanan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <MediaPickerModal :show="showMedia" accept="image" @close="showMedia = false" @select="(m) => { form.image_path = m.file_path; showMedia = false; }" />
    </AdminLayout>
</template>
