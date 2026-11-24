<script setup>
import { watch, ref, onBeforeUnmount } from 'vue';
import { useEditor, EditorContent } from '@tiptap/vue-3';
import StarterKit from '@tiptap/starter-kit';
import LinkExt from '@tiptap/extension-link';
import ImageExt from '@tiptap/extension-image';
import Underline from '@tiptap/extension-underline';
import Placeholder from '@tiptap/extension-placeholder';
import MediaPickerModal from '@/Components/Admin/MediaPickerModal.vue';
import {
    Bold,
    Heading2,
    Heading3,
    Image as ImageIcon,
    Italic,
    Link2,
    List,
    ListOrdered,
    Quote,
    Redo2,
    Underline as UnderlineIcon,
    Undo2,
} from 'lucide-vue-next';

const props = defineProps({
    modelValue: { type: String, default: '' },
    placeholder: { type: String, default: 'Tulis konten di sini seperti di WordPress...' },
});

const emit = defineEmits(['update:modelValue']);
const showMediaPicker = ref(false);

const editor = useEditor({
    content: props.modelValue || '',
    extensions: [
        StarterKit,
        Underline,
        LinkExt.configure({ openOnClick: false }),
        ImageExt,
        Placeholder.configure({ placeholder: props.placeholder }),
    ],
    onUpdate: ({ editor }) => {
        emit('update:modelValue', editor.getHTML());
    },
});

watch(
    () => props.modelValue,
    (val) => {
        if (editor.value && editor.value.getHTML() !== (val || '')) {
            editor.value.commands.setContent(val || '', false);
        }
    }
);

onBeforeUnmount(() => {
    editor.value?.destroy();
});

const setLink = () => {
    const prev = editor.value.getAttributes('link').href;
    const url = window.prompt('Masukkan URL tautan (contoh: https://...):', prev || 'https://');
    if (url === null) return;
    if (url === '') {
        editor.value.chain().focus().extendMarkRange('link').unsetLink().run();
        return;
    }
    editor.value.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
};

const insertImage = (media) => {
    if (media?.file_path) {
        editor.value.chain().focus().setImage({ src: media.file_path, alt: media.alt_text || '' }).run();
    }
    showMediaPicker.value = false;
};
</script>

<template>
    <div class="tiptap-editor rounded-xl border border-slate-300 bg-white overflow-hidden focus-within:border-navy-800 focus-within:ring-2 focus-within:ring-navy-800/10">
        <!-- Toolbar -->
        <div v-if="editor" class="flex flex-wrap items-center gap-1 px-2.5 py-2 bg-slate-50 border-b border-slate-200">
            <button
                type="button"
                @click="editor.chain().focus().toggleBold().run()"
                :class="editor.isActive('bold') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Bold"
            >
                <Bold :size="15" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleItalic().run()"
                :class="editor.isActive('italic') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Italic"
            >
                <Italic :size="15" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleUnderline().run()"
                :class="editor.isActive('underline') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Underline"
            >
                <UnderlineIcon :size="15" />
            </button>
            <span class="w-px h-5 bg-slate-300 mx-1" />
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
                :class="editor.isActive('heading', { level: 2 }) ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Heading 2"
            >
                <Heading2 :size="15" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
                :class="editor.isActive('heading', { level: 3 }) ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Heading 3"
            >
                <Heading3 :size="15" />
            </button>
            <span class="w-px h-5 bg-slate-300 mx-1" />
            <button
                type="button"
                @click="editor.chain().focus().toggleBulletList().run()"
                :class="editor.isActive('bulletList') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Bullet List"
            >
                <List :size="15" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleOrderedList().run()"
                :class="editor.isActive('orderedList') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Numbered List"
            >
                <ListOrdered :size="15" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().toggleBlockquote().run()"
                :class="editor.isActive('blockquote') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Quote"
            >
                <Quote :size="15" />
            </button>
            <span class="w-px h-5 bg-slate-300 mx-1" />
            <button
                type="button"
                @click="setLink"
                :class="editor.isActive('link') ? 'bg-navy-900 text-white' : 'text-slate-700 hover:bg-slate-200'"
                class="p-1.5 rounded-lg transition cursor-pointer"
                title="Link"
            >
                <Link2 :size="15" />
            </button>
            <button
                type="button"
                @click="showMediaPicker = true"
                class="p-1.5 rounded-lg text-slate-700 hover:bg-slate-200 transition cursor-pointer"
                title="Sisipkan Gambar dari Media Library"
            >
                <ImageIcon :size="15" />
            </button>
            <span class="w-px h-5 bg-slate-300 mx-1" />
            <button
                type="button"
                @click="editor.chain().focus().undo().run()"
                class="p-1.5 rounded-lg text-slate-700 hover:bg-slate-200 transition cursor-pointer"
                title="Undo"
            >
                <Undo2 :size="15" />
            </button>
            <button
                type="button"
                @click="editor.chain().focus().redo().run()"
                class="p-1.5 rounded-lg text-slate-700 hover:bg-slate-200 transition cursor-pointer"
                title="Redo"
            >
                <Redo2 :size="15" />
            </button>
        </div>

        <EditorContent :editor="editor" class="prose-carano" />
    </div>

    <MediaPickerModal
        :show="showMediaPicker"
        accept="image"
        @close="showMediaPicker = false"
        @select="insertImage"
    />
</template>
