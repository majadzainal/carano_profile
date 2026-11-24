<script setup>
import { ref } from 'vue';
import { ChevronDown } from 'lucide-vue-next';

const props = defineProps({
    faqs: { type: Array, default: () => [] },
});

const openIndex = ref(0);
const toggle = (idx) => {
    openIndex.value = openIndex.value === idx ? -1 : idx;
};
</script>

<template>
    <div class="divide-y divide-slate-200 border border-slate-200 rounded-2xl bg-white overflow-hidden">
        <div v-for="(faq, idx) in faqs" :key="faq.id" class="transition-colors">
            <button
                type="button"
                @click="toggle(idx)"
                class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left hover:bg-ocean-50/50 transition cursor-pointer"
            >
                <div>
                    <span
                        v-if="faq.category"
                        class="inline-block text-[10px] font-bold uppercase tracking-wider text-ocean-600 mb-1"
                    >
                        {{ faq.category }}
                    </span>
                    <div class="text-sm sm:text-base font-bold text-navy-900">
                        {{ faq.question }}
                    </div>
                </div>
                <ChevronDown
                    :size="20"
                    class="text-gold-600 shrink-0 transition-transform duration-200"
                    :class="openIndex === idx ? 'rotate-180' : ''"
                />
            </button>
            <div v-show="openIndex === idx" class="px-6 pb-5 text-sm text-slate-600 leading-relaxed">
                {{ faq.answer }}
            </div>
        </div>
    </div>
</template>
