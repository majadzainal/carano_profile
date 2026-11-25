<script setup>
import { computed, ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import MediaPickerModal from '@/Components/Admin/MediaPickerModal.vue';
import { Image as ImageIcon, Save } from 'lucide-vue-next';

const props = defineProps({
    settings: { type: Array, default: () => [] },
});

const form = useForm({
    items: props.settings.map((s) => ({
        id: s.id,
        key: s.key,
        group: s.group,
        label: s.label,
        type: s.type,
        value_id: s.value_id || '',
        value_en: s.value_en || '',
    })),
});

const activeGroup = ref('brand');
const pickerTargetIndex = ref(null);
const pickerAccept = ref('all');

const groups = [
    { key: 'brand', label: 'Identitas Brand, Logo & PDF' },
    { key: 'contact', label: 'Kontak & Alamat Kantor' },
    { key: 'social', label: 'Media Sosial' },
    { key: 'seo', label: 'SEO Global' },
];

const filteredItems = computed(() =>
    form.items
        .map((item, idx) => ({ item, idx }))
        .filter(({ item }) => item.group === activeGroup.value)
);

const openPicker = (idx, type) => {
    pickerTargetIndex.value = idx;
    pickerAccept.value = type === 'image' ? 'image' : 'pdf';
};

const onMediaSelected = (media) => {
    if (pickerTargetIndex.value !== null) {
        form.items[pickerTargetIndex.value].value_id = media.file_path;
        form.items[pickerTargetIndex.value].value_en = media.file_path;
    }
    pickerTargetIndex.value = null;
};

const submit = () => {
    form.put('/carano-admin/settings', { preserveScroll: true });
};
</script>

<template>
    <Head title="Pengaturan Situs — CMS" />

    <AdminLayout title="Pengaturan Situs & Identitas">
        <div class="flex flex-wrap gap-2 mb-6">
            <button
                v-for="g in groups"
                :key="g.key"
                type="button"
                @click="activeGroup = g.key"
                class="px-4 py-2 rounded-xl text-xs font-bold border transition cursor-pointer"
                :class="activeGroup === g.key ? 'bg-navy-900 text-white border-navy-900' : 'bg-white text-slate-600 border-slate-200 hover:border-navy-800'"
            >
                {{ g.label }}
            </button>
        </div>

        <form @submit.prevent="submit" class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-8 space-y-6">
            <div v-for="{ item, idx } in filteredItems" :key="item.id" class="pb-5 border-b border-slate-100 last:border-0 last:pb-0">
                <div class="flex items-center justify-between mb-2">
                    <label class="text-sm font-extrabold text-navy-950">{{ item.label }}</label>
                    <span class="text-[11px] font-mono text-slate-400">{{ item.key }}</span>
                </div>

                <!-- Image or File Picker Setting -->
                <div v-if="item.type === 'image' || item.type === 'file'" class="flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div
                        v-if="item.type === 'image' && item.value_id"
                        class="w-16 h-16 rounded-xl border border-slate-200 p-1.5 flex items-center justify-center shrink-0"
                        :class="item.key.includes('dark') ? 'bg-navy-950' : 'bg-slate-50'"
                    >
                        <img :src="item.value_id" :alt="item.label" class="max-h-full max-w-full object-contain" />
                    </div>
                    <div class="flex-1 flex gap-2 w-full">
                        <input v-model="form.items[idx].value_id" type="text" class="flex-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm font-mono" />
                        <button
                            type="button"
                            @click="openPicker(idx, item.type)"
                            class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-ocean-50 hover:bg-ocean-100 text-navy-900 text-xs font-bold border border-slate-200 cursor-pointer shrink-0"
                        >
                            <ImageIcon :size="15" /> Media Library
                        </button>
                    </div>
                </div>

                <!-- Textarea Bilingual -->
                <div v-else-if="item.type === 'textarea'" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400">Indonesia (ID)</span>
                        <textarea v-model="form.items[idx].value_id" rows="2" class="w-full mt-1 rounded-xl border border-slate-300 px-3.5 py-2 text-sm" />
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400">English (EN)</span>
                        <textarea v-model="form.items[idx].value_en" rows="2" class="w-full mt-1 rounded-xl border border-slate-300 px-3.5 py-2 text-sm" />
                    </div>
                </div>

                <!-- Standard Input -->
                <div v-else class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400">Indonesia (ID)</span>
                        <input v-model="form.items[idx].value_id" type="text" class="w-full mt-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                    <div>
                        <span class="text-[10px] font-bold uppercase text-slate-400">English (EN)</span>
                        <input v-model="form.items[idx].value_en" type="text" class="w-full mt-1 rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                </div>
            </div>

            <div class="pt-4 flex justify-end">
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="inline-flex items-center gap-2 px-7 py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-sm cursor-pointer transition"
                >
                    <Save :size="16" />
                    <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Semua Pengaturan' }}</span>
                </button>
            </div>
        </form>

        <MediaPickerModal
            :show="pickerTargetIndex !== null"
            :accept="pickerAccept"
            @close="pickerTargetIndex = null"
            @select="onMediaSelected"
        />
    </AdminLayout>
</template>
