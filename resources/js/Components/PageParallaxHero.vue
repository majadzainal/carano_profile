<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    badge: { type: String, default: '' },
    title: { type: String, required: true },
    subtitle: { type: String, default: '' },
    image: { type: String, default: '/images/illustrations/hero-port-maritime.jpg' },
});

const scrollY = ref(0);
let raf = null;

const onScroll = () => {
    if (raf) return;
    raf = requestAnimationFrame(() => {
        scrollY.value = Math.min(window.scrollY, 600);
        raf = null;
    });
};

onMounted(() => window.addEventListener('scroll', onScroll, { passive: true }));
onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    if (raf) cancelAnimationFrame(raf);
});

const bgStyle = computed(() => ({
    transform: `translate3d(0, ${scrollY.value * 0.28}px, 0) scale(${1.05 + scrollY.value * 0.00018})`,
}));
</script>

<template>
    <section class="relative overflow-hidden bg-ocean-50 border-b border-slate-200/80 pt-14 pb-16 sm:pt-20 sm:pb-20">
        <!-- Bright Sunlit Parallax Maritime Photo Background -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <img
                :src="image"
                alt=""
                aria-hidden="true"
                class="w-full h-full object-cover object-center opacity-22 will-change-transform"
                :style="bgStyle"
            />
            <!-- Clean airy white-to-ice-blue gradient wash (keeps page bright & readable like hacobu.jp) -->
            <div class="absolute inset-0 bg-gradient-to-r from-white/95 via-white/85 to-ocean-50/65" />
            <div class="absolute inset-0 bg-gradient-to-b from-white/40 via-transparent to-white/90" />
        </div>

        <!-- Subtle Gold Directional Route Accent -->
        <svg class="absolute right-0 bottom-0 w-96 h-40 opacity-30 pointer-events-none" viewBox="0 0 400 160" fill="none">
            <path d="M 20 140 Q 190 20 390 80" stroke="#E6A92E" stroke-width="2.5" class="animate-route-dash" />
        </svg>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8">
                <div class="max-w-3xl">
                    <span
                        v-if="badge"
                        class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white/90 border border-slate-200 text-ocean-600 text-xs font-bold tracking-widest uppercase shadow-2xs mb-4"
                    >
                        <span class="w-2 h-2 rounded-full bg-gold-500" />
                        {{ badge }}
                    </span>
                    <h1 class="text-3xl sm:text-5xl font-extrabold text-navy-950 leading-tight tracking-tight">
                        {{ title }}
                    </h1>
                    <p v-if="subtitle" class="mt-4 text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl">
                        {{ subtitle }}
                    </p>
                    <slot name="below" />
                </div>

                <div v-if="$slots.aside" class="shrink-0">
                    <slot name="aside" />
                </div>
            </div>
        </div>
    </section>
</template>
