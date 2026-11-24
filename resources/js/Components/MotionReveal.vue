<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    delay: { type: Number, default: 0 },
    direction: { type: String, default: 'up' }, // up, left, right, scale
});

const el = ref(null);
const visible = ref(false);
let observer = null;
let safetyTimer = null;

onMounted(() => {
    if (typeof IntersectionObserver === 'undefined') {
        visible.value = true;
        return;
    }

    // Immediate reveal if already in or near viewport
    if (el.value) {
        const rect = el.value.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.98) {
            visible.value = true;
            return;
        }
    }

    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0]?.isIntersecting) {
                visible.value = true;
                observer?.disconnect();
            }
        },
        { threshold: 0.05, rootMargin: '0px 0px 40px 0px' }
    );
    if (el.value) observer.observe(el.value);

    // Fallback guarantee so content is never stuck hidden
    safetyTimer = setTimeout(() => {
        if (el.value) {
            const r = el.value.getBoundingClientRect();
            if (r.top < window.innerHeight + 120) visible.value = true;
        }
    }, 900);
});

onBeforeUnmount(() => {
    observer?.disconnect();
    if (safetyTimer) clearTimeout(safetyTimer);
});

const hiddenClasses = {
    up: 'opacity-0 translate-y-6',
    left: 'opacity-0 -translate-x-6',
    right: 'opacity-0 translate-x-6',
    scale: 'opacity-0 scale-95',
};
</script>

<template>
    <div
        ref="el"
        class="transition-all duration-700 ease-out will-change-transform"
        :class="visible ? 'opacity-100 translate-y-0 translate-x-0 scale-100' : hiddenClasses[direction] || hiddenClasses.up"
        :style="{ transitionDelay: `${delay}ms` }"
    >
        <slot />
    </div>
</template>
