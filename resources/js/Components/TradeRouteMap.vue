<script setup>
import { computed, ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import { Anchor, ArrowUpRight, Factory, Ship } from 'lucide-vue-next';

const props = defineProps({
    hubs: { type: Array, default: () => [] },
    locale: { type: String, default: 'id' },
});

const origins = computed(() => props.hubs.filter((h) => h.type === 'origin'));
const destinations = computed(() => props.hubs.filter((h) => h.type === 'destination'));

const selectedHub = ref(null);
const activeHub = computed(() => selectedHub.value || origins.value[0] || destinations.value[0] || null);

// Compute smooth quadratic Bezier sea-lane paths from origins to destinations
const routes = computed(() => {
    const list = [];
    for (const o of origins.value) {
        for (const d of destinations.value) {
            const cx = (o.map_x + d.map_x) / 2 + (o.map_x > d.map_x ? 45 : -20);
            const cy = (o.map_y + d.map_y) / 2 + 15;
            const highlighted =
                !activeHub.value ||
                activeHub.value.id === o.id ||
                activeHub.value.id === d.id;
            list.push({
                id: `${o.id}-${d.id}`,
                path: `M ${o.map_x} ${o.map_y} Q ${cx} ${cy} ${d.map_x} ${d.map_y}`,
                highlighted,
            });
        }
    }
    return list;
});
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
        <!-- Interactive SVG Maritime Map -->
        <div class="lg:col-span-8 bg-gradient-to-br from-navy-950 via-navy-900 to-navy-800 rounded-3xl p-4 sm:p-6 border border-white/10 shadow-xl relative overflow-hidden">
            <!-- Map Header Badges -->
            <div class="flex flex-wrap items-center justify-between gap-2 mb-3 px-1">
                <div class="inline-flex items-center gap-2 text-xs font-bold tracking-wider uppercase text-gold-400">
                    <Ship :size="15" />
                    <span>{{ locale === 'en' ? 'Export & Import Corridor (East Asia ⇄ Indonesia)' : 'Koridor Ekspor & Impor (Asia Timur ⇄ Indonesia)' }}</span>
                </div>
                <div class="flex items-center gap-4 text-[11px] text-slate-300">
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-gold-400" />
                        {{ locale === 'en' ? 'Asian Partner Hub' : 'Negara Mitra Asia' }}
                    </span>
                    <span class="inline-flex items-center gap-1.5">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-400" />
                        {{ locale === 'en' ? 'Indonesian Port' : 'Pelabuhan Utama RI' }}
                    </span>
                </div>
            </div>

            <svg viewBox="0 0 1000 600" class="w-full h-auto select-none">
                <defs>
                    <radialGradient id="oceanGlow" cx="55%" cy="52%" r="60%">
                        <stop offset="0%" stop-color="#1E4E8C" stop-opacity="0.45" />
                        <stop offset="100%" stop-color="#05122B" stop-opacity="0.1" />
                    </radialGradient>
                </defs>

                <!-- Subtle Ocean Glow & Nautical Grid -->
                <rect x="0" y="0" width="1000" height="600" rx="20" fill="url(#oceanGlow)" />
                <g stroke="#FFFFFF" stroke-opacity="0.06" stroke-width="1">
                    <line v-for="x in [150, 300, 450, 600, 750, 900]" :key="'vx'+x" :x1="x" y1="0" :x2="x" y2="600" />
                    <line v-for="y in [120, 240, 360, 480]" :key="'hy'+y" x1="0" :y1="y" x2="1000" :y2="y" />
                </g>

                <!-- Stylized Regional Landmasses (East & SE Asia + Indonesia Archipelago) -->
                <g fill="#17386E" stroke="#3B6FB6" stroke-opacity="0.4" stroke-width="1.5">
                    <!-- China Mainland -->
                    <path d="M 320 40 L 670 40 L 665 130 L 635 215 L 545 250 L 455 245 L 365 215 L 320 140 Z" />
                    <!-- Korean Peninsula -->
                    <path d="M 695 65 L 740 72 L 736 142 L 705 148 L 692 110 Z" />
                    <!-- Japan Archipelago -->
                    <path d="M 815 62 L 875 76 L 862 140 L 820 175 L 792 155 L 822 110 Z" />
                    <!-- Taiwan -->
                    <path d="M 642 222 L 662 225 L 656 262 L 638 256 Z" />
                    <!-- Indochina & Malay Peninsula -->
                    <path d="M 355 225 L 435 235 L 448 315 L 405 345 L 395 405 L 368 395 L 360 330 L 340 275 Z" />
                    <!-- Philippines -->
                    <path d="M 668 292 L 718 315 L 726 392 L 680 385 L 665 335 Z" />
                    <!-- Sumatra -->
                    <path d="M 275 375 L 352 425 L 402 485 L 378 508 L 310 455 L 260 400 Z" />
                    <!-- Java (Priok -> Emas -> Perak) -->
                    <path d="M 412 492 L 635 510 L 632 536 L 410 520 Z" />
                    <!-- Kalimantan -->
                    <path d="M 485 385 L 598 375 L 615 452 L 515 462 L 478 430 Z" />
                    <!-- Sulawesi -->
                    <path d="M 645 415 L 705 405 L 695 478 L 652 465 Z" />
                </g>

                <!-- Animated Maritime Shipping Lanes -->
                <g fill="none">
                    <path
                        v-for="r in routes"
                        :key="r.id"
                        :d="r.path"
                        :stroke="r.highlighted ? '#E6A92E' : '#64748B'"
                        :stroke-opacity="r.highlighted ? 0.85 : 0.18"
                        :stroke-width="r.highlighted ? 2.4 : 1.2"
                        :class="r.highlighted ? 'animate-route-dash' : ''"
                    />
                </g>

                <!-- Origin Hub Nodes -->
                <g
                    v-for="hub in origins"
                    :key="hub.id"
                    class="cursor-pointer"
                    @click="selectedHub = hub"
                    @mouseenter="selectedHub = hub"
                >
                    <circle
                        :cx="hub.map_x"
                        :cy="hub.map_y"
                        :r="activeHub?.id === hub.id ? 20 : 13"
                        fill="#E6A92E"
                        :fill-opacity="activeHub?.id === hub.id ? 0.28 : 0.15"
                    />
                    <circle
                        :cx="hub.map_x"
                        :cy="hub.map_y"
                        :r="activeHub?.id === hub.id ? 9 : 6.5"
                        fill="#E6A92E"
                        stroke="#FFFFFF"
                        stroke-width="2.2"
                    />
                    <rect
                        :x="hub.map_x - 42"
                        :y="hub.map_y - 34"
                        width="84"
                        height="22"
                        rx="6"
                        :fill="activeHub?.id === hub.id ? '#E6A92E' : '#05122B'"
                        fill-opacity="0.92"
                    />
                    <text
                        :x="hub.map_x"
                        :y="hub.map_y - 19"
                        text-anchor="middle"
                        font-size="11"
                        font-weight="700"
                        :fill="activeHub?.id === hub.id ? '#05122B' : '#FFFFFF'"
                    >
                        {{ hub.name }}
                    </text>
                </g>

                <!-- Destination Port Nodes -->
                <g
                    v-for="hub in destinations"
                    :key="hub.id"
                    class="cursor-pointer"
                    @click="selectedHub = hub"
                    @mouseenter="selectedHub = hub"
                >
                    <circle
                        :cx="hub.map_x"
                        :cy="hub.map_y"
                        :r="activeHub?.id === hub.id ? 18 : 11"
                        fill="#38BDF8"
                        :fill-opacity="activeHub?.id === hub.id ? 0.35 : 0.18"
                    />
                    <circle
                        :cx="hub.map_x"
                        :cy="hub.map_y"
                        :r="activeHub?.id === hub.id ? 8.5 : 6"
                        fill="#38BDF8"
                        stroke="#FFFFFF"
                        stroke-width="2.2"
                    />
                    <text
                        :x="hub.map_x"
                        :y="hub.map_y + 28"
                        text-anchor="middle"
                        font-size="10.5"
                        font-weight="700"
                        :fill="activeHub?.id === hub.id ? '#F2C14E' : '#E2E8F0'"
                    >
                        {{ hub.name.replace('Pelabuhan ', '').replace('Port of ', '') }}
                    </text>
                </g>
            </svg>
        </div>

        <!-- Side Inspector & Quick Selector -->
        <div class="lg:col-span-4 flex flex-col justify-between bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
            <div>
                <!-- Selected Hub Card -->
                <div v-if="activeHub" class="p-5 rounded-2xl bg-ocean-50 border border-slate-200/80 mb-5">
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase"
                            :class="
                                activeHub.type === 'origin'
                                    ? 'bg-gold-500/20 text-navy-900'
                                    : 'bg-sky-500/15 text-navy-900'
                            "
                        >
                            <Factory v-if="activeHub.type === 'origin'" :size="13" />
                            <Anchor v-else :size="13" />
                            {{
                                activeHub.type === 'origin'
                                    ? locale === 'en'
                                        ? 'Origin Country Hub'
                                        : 'Negara Asal'
                                    : locale === 'en'
                                    ? 'Indonesian Gateway'
                                    : 'Pelabuhan Tujuan RI'
                            }}
                        </span>
                        <span class="text-xs font-mono font-bold text-ocean-600">{{ activeHub.code }}</span>
                    </div>
                    <h3 class="text-xl font-extrabold text-navy-900">{{ activeHub.name }}</h3>
                    <div class="text-xs font-medium text-slate-500 mb-3">{{ activeHub.country }}</div>
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ activeHub.description }}
                    </p>
                </div>

                <!-- Quick Lists -->
                <div class="space-y-4">
                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                            {{ locale === 'en' ? '5 Origin Hubs' : '5 Negara Asal Utama' }}
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <button
                                v-for="h in origins"
                                :key="h.id"
                                type="button"
                                @click="selectedHub = h"
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold border transition cursor-pointer"
                                :class="
                                    activeHub?.id === h.id
                                        ? 'bg-navy-900 text-gold-400 border-navy-900'
                                        : 'bg-white text-slate-700 border-slate-200 hover:border-gold-500'
                                "
                            >
                                {{ h.name }}
                            </button>
                        </div>
                    </div>

                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-2">
                            {{ locale === 'en' ? '3 Indonesian Destination Ports' : '3 Pelabuhan Tujuan Indonesia' }}
                        </div>
                        <div class="flex flex-wrap gap-1.5">
                            <button
                                v-for="h in destinations"
                                :key="h.id"
                                type="button"
                                @click="selectedHub = h"
                                class="px-3 py-1.5 rounded-xl text-xs font-semibold border transition cursor-pointer"
                                :class="
                                    activeHub?.id === h.id
                                        ? 'bg-navy-900 text-sky-300 border-navy-900'
                                        : 'bg-white text-slate-700 border-slate-200 hover:border-ocean-500'
                                "
                            >
                                {{ h.name.replace('Pelabuhan ', '').replace('Port of ', '') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-5 border-t border-slate-100">
                <Link
                    href="/kontak"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-navy-900 hover:bg-navy-800 text-white text-sm font-bold transition"
                >
                    <span>{{ locale === 'en' ? 'Request Quotation for This Route' : 'Minta Penawaran Rute Ini' }}</span>
                    <ArrowUpRight :size="16" class="text-gold-400" />
                </Link>
            </div>
        </div>
    </div>
</template>
