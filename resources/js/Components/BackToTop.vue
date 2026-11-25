<script setup>
import { computed, onBeforeUnmount, onMounted, ref } from 'vue';
import { ArrowUp } from 'lucide-vue-next';

const progress = ref(0);
const visible = ref(false);
let raf = null;

const radius = 19;
const circumference = 2 * Math.PI * radius;
const dashOffset = computed(() => circumference * (1 - progress.value));

const update = () => {
    const scrollTop = window.scrollY || document.documentElement.scrollTop || 0;
    const docHeight = document.documentElement.scrollHeight - window.innerHeight;
    progress.value = docHeight > 0 ? Math.min(1, Math.max(0, scrollTop / docHeight)) : 0;
    visible.value = scrollTop > 320;
};

const onScroll = () => {
    if (raf) return;
    raf = requestAnimationFrame(() => {
        update();
        raf = null;
    });
};

const scrollToTop = () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
};

onMounted(() => {
    update();
    window.addEventListener('scroll', onScroll, { passive: true });
});

onBeforeUnmount(() => {
    window.removeEventListener('scroll', onScroll);
    if (raf) cancelAnimationFrame(raf);
});
</script>

<template>
    <button
        type="button"
        @click="scrollToTop"
        aria-label="Kembali ke atas"
        class="fixed bottom-20 right-5 z-40 w-11 h-11 rounded-full bg-white/95 backdrop-blur-md text-navy-900 shadow-lg border border-slate-200 flex items-center justify-center transition-all duration-300 cursor-pointer hover:-translate-y-0.5 active:scale-95"
        :class="visible ? 'opacity-100 translate-y-0 pointer-events-auto' : 'opacity-0 translate-y-3 pointer-events-none'"
    >
        <!-- Circular Scroll Progress Ring -->
        <svg class="absolute inset-0 w-full h-full -rotate-90 pointer-events-none" viewBox="0 0 44 44">
            <circle cx="22" cy="22" :r="radius" fill="none" stroke="#E2E8F0" stroke-width="2.5" />
            <circle
                cx="22"
                cy="22"
                :r="radius"
                fill="none"
                stroke="#E6A92E"
                stroke-width="2.5"
                stroke-linecap="round"
                :stroke-dasharray="circumference"
                :stroke-dashoffset="dashOffset"
            />
        </svg>
        <ArrowUp :size="16" class="relative z-10 text-navy-900" />
    </button>
</template>
