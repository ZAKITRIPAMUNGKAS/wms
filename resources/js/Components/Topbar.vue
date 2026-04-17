<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { 
    PhPackage, 
    PhBell, 
    PhSignOut,
    PhList,
    PhMagnifyingGlass 
} from "@phosphor-icons/vue";
import { uiStore } from '@/Stores/uiStore';

const { auth } = usePage().props;

defineProps({
    title: String
});
</script>

<template>
    <header class="h-16 sticky top-0 bg-white/80 backdrop-blur-xl border-b border-slate-200 flex justify-between items-center px-4 md:px-8 shadow-sm z-30 shrink-0 font-sans">
        <div class="flex items-center gap-4">
            <!-- Mobile Toggle -->
            <button @click="uiStore.toggleSidebar()" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-xl transition-all active:scale-95">
                <PhList :size="24" weight="bold" />
            </button>

            <div class="flex items-center gap-3">
                <PhPackage :size="24" weight="fill" class="text-indigo-600 lg:hidden" />
                <h1 class="text-lg md:text-xl font-black text-slate-800 tracking-tight truncate max-w-[150px] sm:max-w-none">{{ title }}</h1>
            </div>
        </div>

        <!-- Desktop Search -->
        <div class="hidden md:flex flex-1 max-w-md mx-8">
            <div class="relative w-full group">
                <PhMagnifyingGlass :size="18" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-indigo-600 transition-colors" />
                <input type="text" placeholder="Pencarian global..." class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-10 pr-4 py-2 text-sm outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <button class="relative p-2.5 text-slate-400 hover:bg-slate-100 rounded-xl transition-all active:scale-95">
                <PhBell :size="20" weight="bold" />
                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-rose-500 rounded-full border-2 border-white shadow-sm"></span>
            </button>
            
            <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-xs font-bold text-slate-800 leading-tight">{{ auth.user.name }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ auth.user.role?.replace('_', ' ') }}</span>
                </div>
                <img :src="`https://ui-avatars.com/api/?name=${auth.user.name}&background=4f46e5&color=fff`" class="w-9 h-9 rounded-xl shadow-md border border-white" loading="lazy" decoding="async">
            </div>
        </div>
    </header>
</template>
