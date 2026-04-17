<script setup>
import BackgroundBlobs from '@/Components/BackgroundBlobs.vue';
</script>

<template>
    <div class="bg-slate-900 font-sans min-h-screen flex items-center justify-center p-4 md:p-8 relative overflow-hidden">
        <BackgroundBlobs />
        
        <div class="w-full max-w-md bg-white/10 backdrop-blur-3xl border border-white/20 p-6 sm:p-8 md:p-12 rounded-[2.5rem] shadow-2xl relative z-10 flex flex-col transition-all">
            <slot />
        </div>
    </div>
</template>
