<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RichTextEditor from '@/Components/Admin/RichTextEditor.vue';
import MediaPickerModal from '@/Components/Admin/MediaPickerModal.vue';
import { ArrowLeft, Image as ImageIcon, Save } from 'lucide-vue-next';

const props = defineProps({
    post: { type: Object, default: null },
});

const langTab = ref('id');
const showMedia = ref(false);

const form = useForm({
    slug: props.post?.slug || '',
    title_id: props.post?.title_id || '',
    title_en: props.post?.title_en || '',
    excerpt_id: props.post?.excerpt_id || '',
    excerpt_en: props.post?.excerpt_en || '',
    body_id: props.post?.body_id || '',
    body_en: props.post?.body_en || '',
    category: props.post?.category || 'Panduan Impor',
    featured_image: props.post?.featured_image || '',
    meta_title: props.post?.meta_title || '',
    meta_description: props.post?.meta_description || '',
    status: props.post?.status || 'published',
    published_at: props.post?.published_at ? props.post.published_at.slice(0, 10) : new Date().toISOString().slice(0, 10),
});

const submit = () => {
    if (props.post) {
        form.put(`/carano-admin/posts/${props.post.id}`);
    } else {
        form.post('/carano-admin/posts');
    }
};
</script>

<template>
    <Head :title="post ? 'Edit Artikel — CMS' : 'Tulis Artikel Baru — CMS'" />

    <AdminLayout :title="post ? 'Edit Artikel' : 'Tulis Artikel Baru'">
        <div class="mb-5">
            <Link href="/carano-admin/posts" class="inline-flex items-center gap-1.5 text-xs font-bold text-ocean-600 hover:text-navy-900">
                <ArrowLeft :size="15" /> Kembali ke Daftar Artikel
            </Link>
        </div>

        <form @submit.prevent="submit" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
            <!-- Left WordPress-like Main Editor -->
            <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200 p-6 space-y-5">
                <div class="flex gap-2 bg-slate-100 p-1 rounded-xl w-fit">
                    <button type="button" @click="langTab = 'id'" class="px-3.5 py-1.5 rounded-lg text-xs font-bold cursor-pointer" :class="langTab === 'id' ? 'bg-navy-900 text-white' : 'text-slate-600'">Bahasa Indonesia (ID)</button>
                    <button type="button" @click="langTab = 'en'" class="px-3.5 py-1.5 rounded-lg text-xs font-bold cursor-pointer" :class="langTab === 'en' ? 'bg-navy-900 text-white' : 'text-slate-600'">English (EN)</button>
                </div>

                <div v-show="langTab === 'id'" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Judul Artikel (ID) *</label>
                        <input v-model="form.title_id" type="text" required placeholder="Masukkan judul artikel..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base font-bold" />
                        <p v-if="form.errors.title_id" class="text-xs text-rose-600 mt-1">{{ form.errors.title_id }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Ringkasan / Excerpt (ID)</label>
                        <textarea v-model="form.excerpt_id" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Isi Artikel (WYSIWYG — ID)</label>
                        <RichTextEditor v-model="form.body_id" />
                    </div>
                </div>

                <div v-show="langTab === 'en'" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Article Title (EN)</label>
                        <input v-model="form.title_en" type="text" placeholder="Enter English title..." class="w-full rounded-xl border border-slate-300 px-4 py-3 text-base font-bold" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Excerpt (EN)</label>
                        <textarea v-model="form.excerpt_en" rows="2" class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1.5">Article Body (WYSIWYG — EN)</label>
                        <RichTextEditor v-model="form.body_en" />
                    </div>
                </div>

                <!-- SEO Box -->
                <div class="pt-5 border-t border-slate-100 space-y-3">
                    <div class="text-xs font-extrabold uppercase tracking-wider text-ocean-600">Pengaturan SEO Artikel</div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Meta Title (Opsional)</label>
                        <input v-model="form.meta_title" type="text" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Meta Description (Opsional)</label>
                        <textarea v-model="form.meta_description" rows="2" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm" />
                    </div>
                </div>
            </div>

            <!-- Right WordPress-like Publish Sidebar -->
            <div class="lg:col-span-4 space-y-5">
                <div class="bg-white rounded-3xl border border-slate-200 p-5 space-y-4">
                    <div class="text-sm font-extrabold text-navy-950 border-b border-slate-100 pb-3">Publikasi</div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Status</label>
                        <select v-model="form.status" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm bg-white">
                            <option value="published">Published (Tayang)</option>
                            <option value="draft">Draft (Simpan Dulu)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Terbit</label>
                        <input v-model="form.published_at" type="date" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Kategori</label>
                        <input v-model="form.category" type="text" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Slug URL (Opsional)</label>
                        <input v-model="form.slug" type="text" placeholder="otomatis-dari-judul" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-xs font-mono" />
                    </div>

                    <button
                        type="submit"
                        :disabled="form.processing"
                        class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-sm shadow-sm cursor-pointer transition"
                    >
                        <Save :size="16" />
                        <span>{{ form.processing ? 'Menyimpan...' : post ? 'Perbarui Artikel' : 'Terbitkan Artikel' }}</span>
                    </button>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 p-5 space-y-3">
                    <div class="text-sm font-extrabold text-navy-950">Featured Image</div>
                    <div v-if="form.featured_image" class="rounded-xl overflow-hidden border border-slate-200">
                        <img :src="form.featured_image" alt="Featured" class="w-full h-40 object-cover" />
                    </div>
                    <div class="flex gap-2">
                        <input v-model="form.featured_image" type="text" placeholder="/uploads/images/..." class="flex-1 rounded-xl border border-slate-300 px-3 py-2 text-xs" />
                        <button type="button" @click="showMedia = true" class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-ocean-50 text-navy-900 text-xs font-bold border border-slate-200 cursor-pointer">
                            <ImageIcon :size="14" /> Pilih
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <MediaPickerModal :show="showMedia" accept="image" @close="showMedia = false" @select="(m) => { form.featured_image = m.file_path; showMedia = false; }" />
    </AdminLayout>
</template>
