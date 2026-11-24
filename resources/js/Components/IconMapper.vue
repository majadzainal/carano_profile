<script setup>
import { computed } from 'vue';
import {
    Anchor,
    ArrowDownCircle,
    Box,
    Compass,
    Container,
    Factory,
    FileCheck2,
    Globe,
    MapPinCheck,
    Package,
    Plane,
    Radar,
    ShieldCheck,
    Ship,
    Truck,
} from 'lucide-vue-next';

const props = defineProps({
    name: { type: String, default: 'ship' },
    size: { type: Number, default: 20 },
});

const icons = {
    factory: Factory,
    truck: Truck,
    anchor: Anchor,
    'file-check': FileCheck2,
    container: Container,
    ship: Ship,
    radar: Radar,
    'arrow-down-circle': ArrowDownCircle,
    'shield-check': ShieldCheck,
    'map-pin-check': MapPinCheck,
    plane: Plane,
    globe: Globe,
    package: Package,
    box: Box,
    compass: Compass,
};

const resolved = computed(() => icons[props.name] || Ship);
</script>

<template>
    <component :is="resolved" :size="size" />
</template>
