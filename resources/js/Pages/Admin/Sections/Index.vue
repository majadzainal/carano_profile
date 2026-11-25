<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichTextEditor from '@/Components/Admin/RichTextEditor.vue';
import MediaPickerModal from '@/Components/Admin/MediaPickerModal.vue';
import { Image as ImageIcon, Save } from 'lucide-vue-next';

const props = defineProps({
    sections: { type: Array, default: () => [] },
});

const selected = ref(props.sections[0] || null);
const langTab = ref('id');
const showMedia = ref(false);

const form = useForm({
    badge_id: '',
    badge_en: '',
    title_id: '',
    title_en: '',
    subtitle_id: '',
    subtitle_en: '',
    body_id: '',
    body_en: '',
    cta_label_id: '',
    cta_label_en: '',
    cta_url: '',
    secondary_cta_label_id: '',
    secondary_cta_label_en: '',
    secondary_cta_url: '',
    image_path: '',
    extra_json: null,
    is_active: true,
});

const extraJsonText = ref('');

const loadSection = (sec) => {
    selected.value = sec;
    form.badge_id = sec.badge_id || '';
    form.badge_en = sec.badge_en || '';
    form.title_id = sec.title_id || '';
    form.title_en = sec.title_en || '';
    form.subtitle_id = sec.subtitle_id || '';
    form.subtitle_en = sec.subtitle_en || '';
    form.body_id = sec.body_id || '';
    form.body_en = sec.body_en || '';
    form.cta_label_id = sec.cta_label_id || '';
    form.cta_label_en = sec.cta_label_en || '';
    form.cta_url = sec.cta_url || '';
    form.secondary_cta_label_id = sec.secondary_cta_label_id || '';
    form.secondary_cta_label_en = sec.secondary_cta_label_en || '';
    form.secondary_cta_url = sec.secondary_cta_url || '';
    form.image_path = sec.image_path || '';
    form.extra_json = sec.extra_json || null;
    form.is_active = Boolean(sec.is_active);
    extraJsonText.value = sec.extra_json ? JSON.stringify(sec.extra_json, null, 2) : '';
};

if (selected.value) loadSection(selected.value);

const saveSection = () => {
    if (!selected.value) return;
    if (extraJsonText.value.trim()) {
        try {
            form.extra_json = JSON.parse(extraJsonText.value);
        } catch {
            alert('Format JSON pada Data Tambahan tidak valid. Mohon periksa tanda kurung/koma.');
            return;
        }
    } else {
        form.extra_json = null;
    }

    form.put(`/carano-admin/sections/${selected.value.id}`, {
        preserveScroll: true,
    });
};

const onSelectMedia = (media) => {
    form.image_path = media.file_path;
    showMedia.value = false;
};
</script>

<template>
    <Head title="Konten Halaman — CMS" />

    <AdminLayout title="Editor Konten Halaman">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            <!-- Left Section Selector -->
            <div class="lg:col-span-4 space-y-2">
                <div class="text-xs font-bold uppercase tracking-wider text-slate-500 px-1 mb-2">
                    Pilih Blok Halaman ({{ sections.length }})
                </div>
                <button
                    v-for="sec in sections"
                    :key="sec.id"
                    type="button"
                    @click="loadSection(sec)"
                    class="w-full text-left p-4 rounded-2xl border transition cursor-pointer"
                    :class="
                        selected?.id === sec.id
                            ? 'bg-navy-900 text-white border-navy-900 shadow-md'
                            : 'bg-white text-slate-700 border-slate-200 hover:border-ocean-500'
                    "
                >
                    <div class="flex items-center justify-between gap-2">
                        <span class="text-sm font-bold">{{ sec.section_label }}</span>
                        <span
                            class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase"
                            :class="sec.is_active ? 'bg-emerald-500/20 text-emerald-400' : 'bg-slate-200 text-slate-600'"
                        >
                            {{ sec.page_slug }}
                        </span>
                    </div>
                    <div
                        class="text-xs mt-1 truncate"
                        :class="selected?.id === sec.id ? 'text-slate-300' : 'text-slate-400'"
                    >
                        {{ sec.title_id || sec.section_key }}
                    </div>
                </button>
            </div>

            <!-- Right Form Editor -->
            <div v-if="selected" class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 p-6 sm:p-7">
                <div class="flex flex-wrap items-center justify-between gap-4 pb-5 border-b border-slate-100 mb-6">
                    <div>
                        <div class="text-xs font-mono text-ocean-600 font-bold">{{ selected.section_key }}</div>
                        <h2 class="text-xl font-extrabold text-navy-950">{{ selected.section_label }}</h2>
                    </div>

                    <div class="flex items-center gap-2 bg-slate-100 p-1 rounded-xl">
                        <button
                            type="button"
                            @click="langTab = 'id'"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold cursor-pointer transition"
                            :class="langTab === 'id' ? 'bg-navy-900 text-white' : 'text-slate-600'"
                        >
                            Bahasa Indonesia (ID)
                        </button>
                        <button
                            type="button"
                            @click="langTab = 'en'"
                            class="px-3.5 py-1.5 rounded-lg text-xs font-bold cursor-pointer transition"
                            :class="langTab === 'en' ? 'bg-navy-900 text-white' : 'text-slate-600'"
                        >
                            English (EN)
                        </button>
                    </div>
                </div>

                <form @submit.prevent="saveSection" class="space-y-5">
                    <div v-show="langTab === 'id'" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Badge / Eyebrow (ID)</label>
                            <input v-model="form.badge_id" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Judul Utama (ID)</label>
                            <input v-model="form.title_id" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Subjudul / Ringkasan (ID)</label>
                            <textarea v-model="form.subtitle_id" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                        </div>
                        <div v-if="selected.section_key === 'about_story' || form.body_id">
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Konten Lengkap (WYSIWYG — ID)</label>
                            <RichTextEditor v-model="form.body_id" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Label Tombol Utama (ID)</label>
                                <input v-model="form.cta_label_id" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Label Tombol Sekunder (ID)</label>
                                <input v-model="form.secondary_cta_label_id" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                            </div>
                        </div>
                    </div>

                    <div v-show="langTab === 'en'" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Badge / Eyebrow (EN)</label>
                            <input v-model="form.badge_en" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Headline (EN)</label>
                            <input v-model="form.title_en" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-semibold" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Subtitle (EN)</label>
                            <textarea v-model="form.subtitle_en" rows="3" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                        </div>
                        <div v-if="selected.section_key === 'about_story' || form.body_en">
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Full Content (WYSIWYG — EN)</label>
                            <RichTextEditor v-model="form.body_en" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Primary Button Label (EN)</label>
                                <input v-model="form.cta_label_en" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Secondary Button Label (EN)</label>
                                <input v-model="form.secondary_cta_label_en" type="text" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                            </div>
                        </div>
                    </div>

                    <!-- Shared URLs & Image -->
                    <div class="pt-4 border-t border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">URL Tombol Utama</label>
                            <input v-model="form.cta_url" type="text" placeholder="/kontak" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">URL Tombol Sekunder</label>
                            <input v-model="form.secondary_cta_url" type="text" placeholder="/uploads/docs/..." class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Gambar Banner / Visual (Opsional)</label>
                        <div class="flex gap-2">
                            <input v-model="form.image_path" type="text" placeholder="/uploads/images/..." class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                            <button
                                type="button"
                                @click="showMedia = true"
                                class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-ocean-50 hover:bg-ocean-100 text-navy-900 text-xs font-bold border border-slate-200 cursor-pointer"
                            >
                                <ImageIcon :size="15" />
                                Pilih Media
                            </button>
                        </div>
                    </div>

                    <div v-if="extraJsonText">
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Data Terstruktur Section (Metrics / Kartu / Visi & Misi — JSON)</label>
                        <textarea v-model="extraJsonText" rows="8" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-xs font-mono bg-slate-50" />
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                        <label class="inline-flex items-center gap-2 text-sm font-semibold text-navy-900 cursor-pointer">
                            <input v-model="form.is_active" type="checkbox" class="rounded border-slate-300" />
                            Tampilkan section ini di website
                        </label>
                        <button
                            type="submit"
                            :disabled="form.processing"
                            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-sm transition cursor-pointer"
                        >
                            <Save :size="16" />
                            <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <MediaPickerModal :show="showMedia" accept="image" @close="showMedia = false" @select="onSelectMedia" />
    </AdminLayout>
</template>
