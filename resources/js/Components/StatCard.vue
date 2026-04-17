<script setup>
defineProps({
    title: String,
    value: [String, Number],
    unit: String,
    icon: Object,
    iconColor: {
        type: String,
        default: 'text-indigo-600'
    },
    iconBg: {
        type: String,
        default: 'bg-indigo-50'
    },
    iconBgHover: {
        type: String,
        default: 'group-hover:bg-indigo-600'
    },
    trend: String,
    trendLabel: String,
    trendColor: {
        type: String,
        default: 'text-emerald-500'
    },
    footerLabel: String,
    footerValue: String,
    footerPulse: Boolean
});
</script>

<template>
    <div class="bg-white p-5 md:p-6 rounded-[2rem] border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-xl hover:-translate-y-1 transition-all duration-300 font-sans">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">{{ title }}</p>
                <h3 class="text-2xl md:text-3xl font-black text-slate-800 mt-1">
                    {{ value }}<span v-if="unit" class="text-sm md:text-lg text-slate-400 font-bold ml-1">{{ unit }}</span>
                </h3>
            </div>
            <div :class="['w-10 h-10 md:w-12 md:h-12 rounded-2xl flex items-center justify-center transition-all duration-500 group-hover:text-white group-hover:rotate-12 group-hover:scale-110', iconBg, iconColor, iconBgHover]">
                <component :is="icon" :size="20" class="md:hidden" />
                <component :is="icon" :size="24" class="hidden md:block" />
            </div>
        </div>
        <p v-if="trend" class="text-xs text-slate-500">
            <span :class="['font-bold', trendColor]">{{ trend }}</span> {{ trendLabel }}
        </p>
        <p v-else-if="footerLabel" :class="['text-[11px] md:text-xs text-slate-500 font-bold tracking-tight italic', footerPulse ? 'text-rose-500 animate-pulse' : '']">
            {{ footerLabel }}
        </p>
    </div>
</template>
