<script setup>
import { onBeforeUnmount, onMounted, ref, watch } from 'vue';

const props = defineProps({
    animationData: { type: Object, required: true },
    loop: { type: Boolean, default: true },
    autoplay: { type: Boolean, default: true },
    speed: { type: Number, default: 1 },
    ariaLabel: { type: String, default: '' },
});

const container = ref(null);
let animInstance = null;
let observer = null;
let lottieLib = null;

const prefersReducedMotion = () =>
    typeof window !== 'undefined' &&
    window.matchMedia &&
    window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const mountAnimation = async () => {
    if (!container.value || !props.animationData) return;

    if (!lottieLib) {
        const mod = await import('lottie-web/build/player/lottie_light');
        lottieLib = mod.default || mod;
    }

    if (animInstance) {
        animInstance.destroy();
        animInstance = null;
    }

    const reduced = prefersReducedMotion();
    animInstance = lottieLib.loadAnimation({
        container: container.value,
        renderer: 'svg',
        loop: reduced ? false : props.loop,
        autoplay: reduced ? false : props.autoplay,
        animationData: JSON.parse(JSON.stringify(props.animationData)),
        rendererSettings: {
            preserveAspectRatio: 'xMidYMid meet',
        },
    });
    animInstance.setSpeed(props.speed);

    if (reduced) {
        // Show final crisp frame for reduced-motion accessibility
        animInstance.goToAndStop(Math.max(0, animInstance.totalFrames - 1), true);
    }
};

onMounted(async () => {
    if (typeof IntersectionObserver !== 'undefined' && container.value) {
        observer = new IntersectionObserver(
            (entries) => {
                const visible = entries[0]?.isIntersecting;
                if (visible) {
                    if (!animInstance) {
                        mountAnimation();
                    } else if (!prefersReducedMotion() && props.autoplay) {
                        animInstance.play();
                    }
                } else if (animInstance && props.loop) {
                    animInstance.pause();
                }
            },
            { threshold: 0.05, rootMargin: '80px' }
        );
        observer.observe(container.value);
    } else {
        await mountAnimation();
    }
});

watch(
    () => props.animationData,
    () => {
        mountAnimation();
    }
);

onBeforeUnmount(() => {
    observer?.disconnect();
    if (animInstance) {
        animInstance.destroy();
        animInstance = null;
    }
});
</script>

<template>
    <div
        ref="container"
        class="lottie-host inline-block select-none"
        :aria-label="ariaLabel || undefined"
        :aria-hidden="ariaLabel ? undefined : 'true'"
    />
</template>
