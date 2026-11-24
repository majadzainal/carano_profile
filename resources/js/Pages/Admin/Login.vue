<script setup>
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { Lock } from 'lucide-vue-next';

const page = usePage();
const settings = computed(() => page.props.settings || {});

const form = useForm({
    email: 'admin@caranologistik.co.id',
    password: '',
    remember: true,
});

const submit = () => {
    form.post('/carano-admin/login');
};
</script>

<template>
    <Head title="Login CMS â€” PT. CARANO UTAMA LOGISTIK" />

    <div class="min-h-screen bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-3xl p-8 sm:p-10 shadow-2xl border border-white/10">
            <div class="flex flex-col items-center text-center mb-8">
                <img
                    :src="settings.logo_light || '/images/brand/logo-carano-light.png'"
                    alt="PT. CARANO UTAMA LOGISTIK"
                    class="h-20 w-20 object-contain mb-3"
                />
                <h1 class="text-xl font-extrabold text-navy-950">CARANO CMS Portal</h1>
                <p class="text-xs text-slate-500 mt-1">Masuk untuk mengelola konten website PT. CARANO UTAMA LOGISTIK</p>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">Email Admin</label>
                    <input
                        v-model="form.email"
                        type="email"
                        required
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                    />
                    <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-navy-900 mb-1.5">Kata Sandi</label>
                    <input
                        v-model="form.password"
                        type="password"
                        required
                        placeholder="â€¢â€¢â€¢â€¢â€¢â€¢â€¢â€¢"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm focus:border-navy-800 focus:ring-2 focus:ring-navy-800/15 outline-none"
                    />
                    <p v-if="form.errors.password" class="text-xs text-rose-600 mt-1">{{ form.errors.password }}</p>
                </div>

                <label class="flex items-center gap-2 text-xs text-slate-600 cursor-pointer">
                    <input v-model="form.remember" type="checkbox" class="rounded border-slate-300 text-navy-900" />
                    <span>Ingat sesi login saya</span>
                </label>

                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl bg-navy-900 hover:bg-navy-800 text-white font-bold text-sm shadow-md transition disabled:opacity-60 cursor-pointer"
                >
                    <Lock :size="16" class="text-gold-400" />
                    <span>{{ form.processing ? 'Memeriksa...' : 'Masuk ke Dashboard CMS' }}</span>
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <Link href="/" class="text-xs font-semibold text-ocean-600 hover:text-navy-900">
                    â† Kembali ke Website Utama
                </Link>
            </div>
        </div>
    </div>
</template>
