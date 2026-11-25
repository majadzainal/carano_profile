<script setup>
import { computed, onBeforeUnmount, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import IconMapper from '@/Components/IconMapper.vue';
import LottiePlayer from '@/Components/LottiePlayer.vue';
import originCargoAnim from '@/assets/lottie/origin-cargo.json';
import oceanVesselAnim from '@/assets/lottie/ocean-vessel.json';
import customsVerifiedAnim from '@/assets/lottie/customs-verified.json';
import {
    ArrowRight,
    CheckCircle2,
    ChevronLeft,
    ChevronRight,
    Download,
    Pause,
    Play,
    Ship,
} from 'lucide-vue-next';

const props = defineProps({
    steps: { type: Array, default: () => [] },
    locale: { type: String, default: 'id' },
    brochureUrl: { type: String, default: '/uploads/docs/CARANO_Road_Map_Shipment.pdf' },
});

const activePhase = ref('all');
const selectedIndex = ref(0);
const isPlaying = ref(false);
let playTimer = null;

const phases = computed(() =>
    props.locale === 'en'
        ? [
              { key: 'all', label: 'All Stages (1–10)' },
              { key: 'origin', label: 'Phase 1: Origin Handling (1–4)' },
              { key: 'sea', label: 'Phase 2: Ocean Freight (5–6)' },
              { key: 'destination', label: 'Phase 3: Port & Delivery (7–10)' },
          ]
        : [
              { key: 'all', label: 'Semua Tahap (1–10)' },
              { key: 'origin', label: 'Fase 1: Negara Asal (1–4)' },
              { key: 'sea', label: 'Fase 2: Perjalanan Laut (5–6)' },
              { key: 'destination', label: 'Fase 3: Pelabuhan & Delivery (7–10)' },
          ]
);

const filteredSteps = computed(() => {
    if (activePhase.value === 'all') return props.steps;
    return props.steps.filter((s) => s.phase === activePhase.value);
});

const activeStep = computed(() => {
    const list = filteredSteps.value;
    if (!list.length) return null;
    const idx = Math.min(selectedIndex.value, list.length - 1);
    return list[idx];
});

const activePhaseAnimation = computed(() => {
    const phase = activeStep.value?.phase;
    if (phase === 'sea') return oceanVesselAnim;
    if (phase === 'destination') return customsVerifiedAnim;
    return originCargoAnim;
});

const progressPercent = computed(() => {
    if (!filteredSteps.value.length) return 0;
    return Math.round(((selectedIndex.value + 1) / filteredSteps.value.length) * 100);
});

const stopPlay = () => {
    isPlaying.value = false;
    if (playTimer) {
        clearInterval(playTimer);
        playTimer = null;
    }
};

const togglePlay = () => {
    if (isPlaying.value) {
        stopPlay();
        return;
    }
    isPlaying.value = true;
    playTimer = setInterval(() => {
        if (selectedIndex.value < filteredSteps.value.length - 1) {
            selectedIndex.value++;
        } else {
            selectedIndex.value = 0;
        }
    }, 2800);
};

onBeforeUnmount(() => stopPlay());

const selectPhase = (phaseKey) => {
    stopPlay();
    activePhase.value = phaseKey;
    selectedIndex.value = 0;
};

const selectStep = (idx) => {
    stopPlay();
    selectedIndex.value = idx;
};

const phaseBadge = (phase) => {
    if (phase === 'origin') {
        return {
            text: props.locale === 'en' ? 'Origin Logistics' : 'Fase Negara Asal',
            cls: 'bg-ocean-100 text-navy-800 border-ocean-500/20',
        };
    }
    if (phase === 'sea') {
        return {
            text: props.locale === 'en' ? 'Ocean Transit' : 'Fase Perjalanan Laut',
            cls: 'bg-navy-900 text-gold-400 border-navy-800',
        };
    }
    return {
        text: props.locale === 'en' ? 'Indonesian Port & Delivery' : 'Fase Pelabuhan RI & Delivery',
        cls: 'bg-gold-100 text-navy-900 border-gold-500/30',
    };
};

const prevStep = () => {
    stopPlay();
    if (selectedIndex.value > 0) selectedIndex.value--;
};

const nextStep = () => {
    stopPlay();
    if (selectedIndex.value < filteredSteps.value.length - 1) selectedIndex.value++;
};
</script>

<template>
    <div class="space-y-7">
        <!-- Phase Filter Tabs + Interactive Voyage Auto-Play -->
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap gap-2">
                <button
                    v-for="p in phases"
                    :key="p.key"
                    type="button"
                    @click="selectPhase(p.key)"
                    class="px-4 py-2 text-xs sm:text-sm font-semibold rounded-full border transition-all cursor-pointer"
                    :class="
                        activePhase === p.key
                            ? 'bg-navy-900 text-white border-navy-900 shadow-sm'
                            : 'bg-white text-slate-600 border-slate-200 hover:border-navy-800/40 hover:text-navy-900'
                    "
                >
                    {{ p.label }}
                </button>
            </div>

            <div class="flex items-center gap-3">
                <button
                    type="button"
                    @click="togglePlay"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-full text-xs font-extrabold border transition cursor-pointer"
                    :class="
                        isPlaying
                            ? 'bg-gold-500 text-navy-950 border-gold-500 shadow-sm'
                            : 'bg-white text-navy-900 border-navy-900/25 hover:border-navy-900'
                    "
                >
                    <Pause v-if="isPlaying" :size="14" />
                    <Play v-else :size="14" />
                    <span>
                        {{
                            isPlaying
                                ? locale === 'en'
                                    ? 'Pause Simulation'
                                    : 'Jeda Simulasi'
                                : locale === 'en'
                                ? 'Play Shipment Journey'
                                : 'Simulasi Alur 1→10'
                        }}
                    </span>
                </button>

                <a
                    :href="brochureUrl"
                    target="_blank"
                    class="inline-flex items-center gap-1.5 text-xs font-semibold text-navy-800 hover:text-gold-600 transition"
                >
                    <Download :size="15" />
                    <span class="hidden sm:inline">{{ locale === 'en' ? 'Official PDF' : 'Diagram PDF' }}</span>
                </a>
            </div>
        </div>

        <!-- Animated Live Voyage Progress Rail -->
        <div class="bg-white rounded-2xl border border-slate-200 px-4 sm:px-5 py-4 overflow-hidden">
            <div class="flex flex-wrap items-center justify-between gap-1 text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-slate-500 mb-2">
                <span class="hidden sm:inline">{{ locale === 'en' ? 'Origin Factory' : 'Gudang Pabrik Asal' }}</span>
                <span class="text-navy-900 font-extrabold">
                    {{ locale === 'en' ? 'Journey Progress' : 'Progres Pengiriman' }}: {{ progressPercent }}%
                </span>
                <span class="hidden sm:inline">{{ locale === 'en' ? 'Final Warehouse Delivery' : 'Delivery ke Tujuan' }}</span>
            </div>
            <div class="px-3.5">
                <div class="relative h-2.5 rounded-full bg-slate-100 overflow-visible">
                    <div
                        class="h-full rounded-full bg-gradient-to-r from-ocean-600 via-navy-800 to-gold-500 transition-all duration-500"
                        :style="{ width: `${progressPercent}%` }"
                    />
                    <div
                        class="absolute top-1/2 -translate-y-1/2 -translate-x-1/2 w-7 h-7 rounded-full bg-navy-900 border-2 border-gold-400 text-gold-400 flex items-center justify-center shadow-md transition-all duration-500"
                        :style="{ left: `${progressPercent}%` }"
                    >
                        <Ship :size="13" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Visual 10-Node Flow Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">
            <button
                v-for="(step, idx) in filteredSteps"
                :key="step.id"
                type="button"
                @click="selectStep(idx)"
                class="group relative text-left p-4 rounded-2xl border transition-all duration-200 cursor-pointer"
                :class="
                    activeStep && activeStep.id === step.id
                        ? 'bg-navy-900 text-white border-navy-900 shadow-lg ring-2 ring-gold-500/70 -translate-y-0.5'
                        : idx < selectedIndex
                        ? 'bg-gold-50/70 text-navy-900 border-gold-400/50 hover:shadow-md'
                        : 'bg-white text-slate-800 border-slate-200/90 hover:border-ocean-500/50 hover:shadow-md'
                "
            >
                <div class="flex items-center justify-between mb-3">
                    <span
                        class="inline-flex items-center justify-center w-8 h-8 rounded-xl text-xs font-extrabold"
                        :class="
                            activeStep && activeStep.id === step.id
                                ? 'bg-gold-500 text-navy-950'
                                : idx < selectedIndex
                                ? 'bg-navy-900 text-gold-400'
                                : 'bg-ocean-50 text-navy-800 group-hover:bg-navy-900 group-hover:text-gold-400 transition'
                        "
                    >
                        {{ String(step.step_number).padStart(2, '0') }}
                    </span>
                    <IconMapper
                        :name="step.icon"
                        :size="18"
                        :class="activeStep && activeStep.id === step.id ? 'text-gold-400' : 'text-ocean-600'"
                    />
                </div>
                <div
                    class="text-xs font-bold leading-snug line-clamp-2"
                    :class="activeStep && activeStep.id === step.id ? 'text-white' : 'text-navy-900'"
                >
                    {{ step.title }}
                </div>
                <div
                    class="mt-2 h-1 rounded-full transition-all"
                    :class="
                        activeStep && activeStep.id === step.id
                            ? 'w-full bg-gold-500'
                            : idx < selectedIndex
                            ? 'w-full bg-gold-400/70'
                            : 'w-6 bg-slate-200 group-hover:w-12 group-hover:bg-gold-400'
                    "
                />
            </button>
        </div>

        <!-- Detailed Inspector Panel for Active Stage -->
        <div
            v-if="activeStep"
            class="bg-white rounded-3xl border border-slate-200 shadow-[0_14px_45px_rgba(7,26,62,0.06)] overflow-hidden"
        >
            <div class="grid grid-cols-1 lg:grid-cols-12">
                <!-- Left Highlight Column -->
                <div class="lg:col-span-5 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 text-white p-6 sm:p-9 flex flex-col justify-between relative overflow-hidden">
                    <div class="absolute -right-12 -bottom-12 w-48 h-48 rounded-full bg-gold-500/10 blur-2xl pointer-events-none" />
                    <div>
                        <div class="flex flex-wrap items-center justify-between gap-2 mb-6">
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-white/10 text-gold-400 border border-white/15">
                                STEP {{ String(activeStep.step_number).padStart(2, '0') }} / {{ String(steps.length).padStart(2, '0') }}
                            </span>
                            <span
                                class="px-3 py-1 rounded-full text-[11px] font-bold border"
                                :class="phaseBadge(activeStep.phase).cls"
                            >
                                {{ phaseBadge(activeStep.phase).text }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between gap-4 mb-5">
                            <div class="w-14 h-14 rounded-2xl bg-gold-500/15 border border-gold-400/30 flex items-center justify-center text-gold-400 shrink-0">
                                <IconMapper :name="activeStep.icon" :size="28" />
                            </div>
                            <div class="rounded-2xl bg-white/8 border border-white/15 px-3 py-1.5 backdrop-blur-sm">
                                <LottiePlayer
                                    :animation-data="activePhaseAnimation"
                                    class="w-24 h-16 sm:w-28 sm:h-20"
                                />
                            </div>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-extrabold leading-tight text-white">
                            {{ activeStep.title }}
                        </h3>
                    </div>

                    <div class="mt-8 pt-6 border-t border-white/10 flex items-center justify-between">
                        <div class="text-xs text-slate-400">
                            {{ locale === 'en' ? 'Navigate shipment stage' : 'Navigasi tahapan pengiriman' }}
                        </div>
                        <div class="flex items-center gap-2">
                            <button
                                type="button"
                                @click="prevStep"
                                :disabled="selectedIndex === 0"
                                class="p-2 rounded-xl border border-white/15 text-white hover:bg-white/10 disabled:opacity-30 disabled:cursor-not-allowed transition cursor-pointer"
                            >
                                <ChevronLeft :size="18" />
                            </button>
                            <button
                                type="button"
                                @click="nextStep"
                                :disabled="selectedIndex >= filteredSteps.length - 1"
                                class="p-2 rounded-xl bg-gold-500 text-navy-950 hover:bg-gold-400 disabled:opacity-30 disabled:cursor-not-allowed transition cursor-pointer"
                            >
                                <ChevronRight :size="18" />
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Details Column -->
                <div class="lg:col-span-7 p-7 sm:p-9 flex flex-col justify-between">
                    <div>
                        <div class="text-xs font-bold uppercase tracking-widest text-ocean-600 mb-2">
                            {{ locale === 'en' ? 'Operational Process & Accountability' : 'Proses Operasional & Tanggung Jawab CARANO' }}
                        </div>
                        <p class="text-slate-600 text-base leading-relaxed">
                            {{ activeStep.description }}
                        </p>

                        <div v-if="activeStep.highlights && activeStep.highlights.length" class="mt-6">
                            <div class="text-xs font-bold uppercase tracking-wider text-navy-900 mb-3">
                                {{ locale === 'en' ? 'Key Deliverables at This Stage' : 'Poin Utama pada Tahap Ini' }}
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div
                                    v-for="(item, i) in activeStep.highlights"
                                    :key="i"
                                    class="flex items-start gap-2.5 p-3.5 rounded-xl bg-ocean-50/70 border border-slate-200/70"
                                >
                                    <CheckCircle2 :size="18" class="text-gold-600 shrink-0 mt-0.5" />
                                    <span class="text-sm font-medium text-navy-900">{{ item }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-100 flex flex-wrap items-center justify-between gap-4">
                        <div class="text-xs text-slate-500">
                            {{
                                locale === 'en'
                                    ? 'Need tailored advice for this milestone?'
                                    : 'Butuh konsultasi khusus untuk tahapan ini?'
                            }}
                        </div>
                        <Link
                            href="/kontak"
                            class="inline-flex items-center gap-2 text-sm font-bold text-navy-900 hover:text-gold-600 transition"
                        >
                            <span>{{ locale === 'en' ? 'Consult with CARANO Team' : 'Konsultasi dengan Tim CARANO' }}</span>
                            <ArrowRight :size="16" />
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
