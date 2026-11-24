<script setup>
import { onBeforeUnmount, onMounted, ref } from 'vue';

const props = defineProps({
    value: { type: [Number, String], required: true },
    duration: { type: Number, default: 1200 },
});

const el = ref(null);
const display = ref(String(props.value));
let observer = null;
let rafId = null;

const runCount = () => {
    const raw = String(props.value);
    const match = raw.match(/^(\d+(?:\.\d+)?)(.*)$/);
    if (!match) {
        display.value = raw;
        return;
    }
    const target = parseFloat(match[1]);
    const suffix = match[2] || '';
    const start = performance.now();

    const step = (now) => {
        const progress = Math.min((now - start) / props.duration, 1);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = Math.round(target * eased);
        display.value = `${current}${suffix}`;
        if (progress < 1) {
            rafId = requestAnimationFrame(step);
        } else {
            display.value = raw;
        }
    };
    rafId = requestAnimationFrame(step);
};

onMounted(() => {
    if (typeof IntersectionObserver === 'undefined') {
        display.value = String(props.value);
        return;
    }
    observer = new IntersectionObserver(
        (entries) => {
            if (entries[0]?.isIntersecting) {
                runCount();
                observer?.disconnect();
            }
        },
        { threshold: 0.3 }
    );
    if (el.value) observer.observe(el.value);
});

onBeforeUnmount(() => {
    observer?.disconnect();
    if (rafId) cancelAnimationFrame(rafId);
});
</script>

<template>
    <span ref="el">{{ display }}</span>
</template>
