<script setup>
import { ref, watch } from 'vue';
import { FileText, Upload, X } from 'lucide-vue-next';

const props = defineProps({
    show: { type: Boolean, default: false },
    accept: { type: String, default: 'all' }, // all, image, pdf
});

const emit = defineEmits(['close', 'select']);

const files = ref([]);
const loading = ref(false);
const uploading = ref(false);
const errorMsg = ref('');

const loadFiles = async () => {
    loading.value = true;
    try {
        const res = await fetch('/carano-admin/media/list', {
            headers: { Accept: 'application/json' },
        });
        const data = await res.json();
        let list = data.files || [];
        if (props.accept === 'image') {
            list = list.filter((f) => (f.mime_type || '').startsWith('image/'));
        } else if (props.accept === 'pdf') {
            list = list.filter((f) => f.mime_type === 'application/pdf' || f.file_path.endsWith('.pdf'));
        }
        files.value = list;
    } catch {
        errorMsg.value = 'Gagal memuat Media Library.';
    } finally {
        loading.value = false;
    }
};

watch(
    () => props.show,
    (open) => {
        if (open) loadFiles();
    }
);

const uploadQuick = async (e) => {
    const file = e.target.files?.[0];
    if (!file) return;
    uploading.value = true;
    errorMsg.value = '';
    try {
        const formData = new FormData();
        formData.append('file', file);
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const res = await fetch('/carano-admin/media', {
            method: 'POST',
            headers: {
                Accept: 'application/json',
                'X-CSRF-TOKEN': token || '',
            },
            body: formData,
        });
        if (!res.ok) throw new Error('Upload gagal');
        const data = await res.json();
        if (data.file) {
            files.value.unshift(data.file);
            emit('select', data.file);
        }
    } catch {
        errorMsg.value = 'Gagal mengunggah file (maks 10MB, format JPG/PNG/WebP/SVG/PDF).';
    } finally {
        uploading.value = false;
        e.target.value = '';
    }
};
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/70 p-4">
        <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[85vh] flex flex-col overflow-hidden shadow-2xl">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between gap-4">
                <div>
                    <h3 class="text-base font-extrabold text-navy-950">Media Library</h3>
                    <p class="text-xs text-slate-500">Pilih aset atau unggah file baru langsung ke server</p>
                </div>
                <div class="flex items-center gap-3">
                    <label class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 text-xs font-bold cursor-pointer transition">
                        <Upload :size="15" />
                        <span>{{ uploading ? 'Mengunggah...' : 'Upload File Baru' }}</span>
                        <input type="file" class="hidden" @change="uploadQuick" :disabled="uploading" />
                    </label>
                    <button type="button" @click="$emit('close')" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 cursor-pointer">
                        <X :size="20" />
                    </button>
                </div>
            </div>

            <div v-if="errorMsg" class="mx-6 mt-4 p-3 rounded-xl bg-rose-50 text-rose-700 text-xs font-medium">
                {{ errorMsg }}
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <div v-if="loading" class="text-center py-12 text-sm text-slate-500">Memuat Media Library...</div>
                <div v-else-if="!files.length" class="text-center py-12 text-sm text-slate-500">
                    Belum ada file sesuai kategori ini. Silakan unggah file baru.
                </div>
                <div v-else class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    <button
                        v-for="item in files"
                        :key="item.id"
                        type="button"
                        @click="$emit('select', item)"
                        class="group text-left rounded-2xl border border-slate-200 hover:border-gold-500 hover:shadow-md overflow-hidden transition cursor-pointer bg-white"
                    >
                        <div class="h-28 bg-slate-100 flex items-center justify-center overflow-hidden p-2">
                            <img
                                v-if="(item.mime_type || '').startsWith('image/')"
                                :src="item.file_path"
                                :alt="item.alt_text"
                                class="max-h-full max-w-full object-contain group-hover:scale-105 transition"
                            />
                            <div v-else class="flex flex-col items-center text-navy-800">
                                <FileText :size="32" class="text-gold-600" />
                                <span class="text-[10px] font-bold uppercase mt-1">PDF / DOC</span>
                            </div>
                        </div>
                        <div class="p-2.5">
                            <div class="text-xs font-bold text-navy-950 truncate">{{ item.original_name }}</div>
                            <div class="text-[10px] text-slate-400 truncate">{{ item.file_path }}</div>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
