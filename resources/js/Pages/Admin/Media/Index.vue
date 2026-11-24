<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Check, Copy, FileText, Trash2, Upload } from 'lucide-vue-next';

defineProps({
    files: { type: Array, default: () => [] },
});

const copiedId = ref(null);
const uploadForm = useForm({
    file: null,
    alt_text: '',
});

const onFileChange = (e) => {
    uploadForm.file = e.target.files?.[0] || null;
};

const submitUpload = () => {
    if (!uploadForm.file) return;
    uploadForm.post('/carano-admin/media', {
        forceFormData: true,
        onSuccess: () => uploadForm.reset(),
    });
};

const copyPath = async (item) => {
    await navigator.clipboard.writeText(item.file_path);
    copiedId.value = item.id;
    setTimeout(() => (copiedId.value = null), 1800);
};

const remove = (item) => {
    if (!confirm(`Hapus file "${item.original_name}" dari Media Library?`)) return;
    router.delete(`/carano-admin/media/${item.id}`);
};

const formatBytes = (bytes) => {
    if (!bytes) return '0 B';
    const k = 1024;
    const sizes = ['B', 'KB', 'MB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return `${(bytes / Math.pow(k, i)).toFixed(1)} ${sizes[i]}`;
};
</script>

<template>
    <Head title="Media Library â€” CMS" />

    <AdminLayout title="Media Library">
        <!-- Upload Box -->
        <form @submit.prevent="submitUpload" class="bg-white rounded-3xl border border-slate-200 p-6 mb-6 flex flex-col md:flex-row items-stretch md:items-end gap-4">
            <div class="flex-1">
                <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Unggah Gambar atau PDF (Maks 10MB)</label>
                <input
                    type="file"
                    accept=".jpg,.jpeg,.png,.webp,.gif,.svg,.pdf"
                    @change="onFileChange"
                    class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-slate-50"
                />
                <p v-if="uploadForm.errors.file" class="text-xs text-rose-600 mt-1">{{ uploadForm.errors.file }}</p>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Deskripsi / Alt Text (Opsional)</label>
                <input v-model="uploadForm.alt_text" type="text" placeholder="Contoh: Foto Armada Kapal CARANO" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
            </div>
            <button
                type="submit"
                :disabled="!uploadForm.file || uploadForm.processing"
                class="inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm disabled:opacity-50 cursor-pointer transition"
            >
                <Upload :size="16" />
                <span>{{ uploadForm.processing ? 'Mengunggah...' : 'Upload ke Library' }}</span>
            </button>
        </form>

        <!-- Media Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
            <div v-for="item in files" :key="item.id" class="bg-white rounded-2xl border border-slate-200 overflow-hidden flex flex-col justify-between">
                <div class="h-40 bg-slate-100 flex items-center justify-center p-3 overflow-hidden">
                    <img
                        v-if="(item.mime_type || '').startsWith('image/')"
                        :src="item.file_path"
                        :alt="item.alt_text"
                        class="max-h-full max-w-full object-contain"
                    />
                    <a v-else :href="item.file_path" target="_blank" class="flex flex-col items-center text-navy-900 hover:text-gold-600">
                        <FileText :size="40" class="text-gold-600" />
                        <span class="text-xs font-bold mt-2">Buka Dokumen PDF</span>
                    </a>
                </div>
                <div class="p-3.5 space-y-2">
                    <div class="text-xs font-bold text-navy-950 truncate" :title="item.original_name">{{ item.original_name }}</div>
                    <div class="text-[11px] text-slate-400">{{ formatBytes(item.file_size) }} â€¢ {{ item.mime_type }}</div>
                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <button
                            type="button"
                            @click="copyPath(item)"
                            class="inline-flex items-center gap-1 text-xs font-bold text-ocean-600 hover:text-navy-900 cursor-pointer"
                        >
                            <Check v-if="copiedId === item.id" :size="13" class="text-emerald-600" />
                            <Copy v-else :size="13" />
                            <span>{{ copiedId === item.id ? 'Tersalin!' : 'Salin Path' }}</span>
                        </button>
                        <button type="button" @click="remove(item)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 cursor-pointer" title="Hapus">
                            <Trash2 :size="14" />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>
