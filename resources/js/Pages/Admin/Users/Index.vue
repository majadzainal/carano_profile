<script setup>
import { ref } from 'vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Pencil, Plus, Save, Trash2, X } from 'lucide-vue-next';

defineProps({
    users: { type: Array, default: () => [] },
});

const editingId = ref(null);
const showForm = ref(false);

const form = useForm({
    name: '',
    email: '',
    role: 'editor',
    password: '',
});

const openCreate = () => {
    editingId.value = null;
    form.reset();
    form.role = 'editor';
    showForm.value = true;
};

const openEdit = (u) => {
    editingId.value = u.id;
    form.name = u.name;
    form.email = u.email;
    form.role = u.role || 'admin';
    form.password = '';
    showForm.value = true;
};

const submit = () => {
    if (editingId.value) {
        form.put(`/carano-admin/users/${editingId.value}`, { onSuccess: () => (showForm.value = false) });
    } else {
        form.post('/carano-admin/users', { onSuccess: () => (showForm.value = false) });
    }
};

const remove = (u) => {
    if (!confirm(`Hapus pengguna "${u.name}"?`)) return;
    router.delete(`/carano-admin/users/${u.id}`);
};
</script>

<template>
    <Head title="Manajemen Pengguna â€” CMS" />

    <AdminLayout title="Pengguna CMS">
        <div class="flex flex-wrap items-center justify-between gap-4 mb-6">
            <p class="text-sm text-slate-600">Kelola akun Administrator & Editor yang dapat mengakses dashboard CMS.</p>
            <button type="button" @click="openCreate" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gold-500 hover:bg-gold-400 text-navy-950 font-extrabold text-xs cursor-pointer">
                <Plus :size="16" /> Tambah Pengguna
            </button>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5">Nama</th>
                        <th class="px-5 py-3.5">Email</th>
                        <th class="px-5 py-3.5">Peran</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-for="u in users" :key="u.id">
                        <td class="px-5 py-3.5 font-bold text-navy-950">{{ u.name }}</td>
                        <td class="px-5 py-3.5 text-slate-600">{{ u.email }}</td>
                        <td class="px-5 py-3.5">
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-bold uppercase bg-ocean-50 text-ocean-600">{{ u.role }}</span>
                        </td>
                        <td class="px-5 py-3.5 text-right space-x-2">
                            <button type="button" @click="openEdit(u)" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-ocean-50 text-navy-900 text-xs font-bold cursor-pointer">
                                <Pencil :size="13" /> Edit
                            </button>
                            <button type="button" @click="remove(u)" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 cursor-pointer">
                                <Trash2 :size="14" />
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showForm" class="fixed inset-0 z-50 flex items-center justify-center bg-navy-950/70 p-4">
            <div class="bg-white rounded-3xl w-full max-w-md p-6 sm:p-7 shadow-2xl">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-lg font-extrabold text-navy-950">{{ editingId ? 'Edit Pengguna' : 'Tambah Pengguna Baru' }}</h3>
                    <button @click="showForm = false" class="p-2 rounded-lg text-slate-400 hover:bg-slate-100 cursor-pointer"><X :size="20" /></button>
                </div>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Nama Lengkap *</label>
                        <input v-model="form.name" type="text" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Email *</label>
                        <input v-model="form.email" type="email" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">Peran</label>
                        <select v-model="form.role" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm bg-white">
                            <option value="admin">Admin</option>
                            <option value="editor">Editor</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase text-navy-900 mb-1">
                            Password {{ editingId ? '(Kosongkan jika tidak diubah)' : '* (Min. 8 karakter)' }}
                        </label>
                        <input v-model="form.password" type="password" :required="!editingId" class="w-full rounded-xl border border-slate-300 px-3.5 py-2.5 text-sm" />
                        <p v-if="form.errors.password" class="text-xs text-rose-600 mt-1">{{ form.errors.password }}</p>
                    </div>
                    <button type="submit" :disabled="form.processing" class="w-full inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-navy-900 text-white font-bold text-sm cursor-pointer">
                        <Save :size="15" /> Simpan Pengguna
                    </button>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>
