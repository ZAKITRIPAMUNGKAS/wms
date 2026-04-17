<script setup>
import { PhX } from "@phosphor-icons/vue";

defineProps({
    show: Boolean,
    title: String,
    maxWidth: {
        type: String,
        default: 'max-w-2xl'
    }
});

defineEmits(['close']);
</script>

<template>
    <div v-show="show" class="fixed inset-0 z-[100] overflow-hidden font-sans" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Desktop: Backdrop (visible everywhere but more relevant for centered desktop) -->
        <div @click="$emit('close')" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

        <div class="flex items-end md:items-center justify-center min-h-screen p-0 md:p-4">
            <!-- Modal Content -->
            <div :class="[
                'bg-white w-full relative z-10 flex flex-col transition-all duration-300 transform',
                'h-full md:h-auto md:max-h-[90vh] rounded-t-[2.5rem] md:rounded-[2.5rem] shadow-2xl',
                maxWidth
            ]"
            v-show="show">
                <!-- Header: Sticky at top -->
                <div class="sticky top-0 bg-white/90 backdrop-blur-md px-6 md:px-8 py-5 md:py-6 border-b border-slate-100 flex justify-between items-center shrink-0 z-10">
                    <h3 class="text-lg md:text-xl font-black text-slate-800 tracking-tight" id="modal-title">{{ title }}</h3>
                    <button @click="$emit('close')" class="p-2.5 text-slate-400 hover:text-slate-900 hover:bg-slate-100 rounded-2xl transition-all active:scale-95">
                        <PhX :size="24" weight="bold" />
                    </button>
                </div>
                
                <!-- Body: Scrollable -->
                <div class="flex-1 overflow-y-auto overflow-x-hidden scrollbar-hide">
                    <slot />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;
    scrollbar-width: none;
}
</style>
