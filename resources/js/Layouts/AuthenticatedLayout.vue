<script setup>
import Sidebar from '@/Components/Sidebar.vue';
import Topbar from '@/Components/Topbar.vue';

defineProps({
    title: String
});
</script>

<template>
    <div class="bg-slate-50 flex h-screen overflow-hidden text-slate-800 antialiased font-sans">
        
        <!-- Sidebar Shell -->
        <Sidebar />

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden relative">
            <Topbar :title="title" />

            <main class="flex-1 overflow-y-auto overflow-x-hidden p-4 md:p-6 lg:p-8 scrollbar-hide">
                <div class="max-w-7xl mx-auto">
                    <slot />
                </div>
                
                <footer class="max-w-7xl mx-auto mt-16 pb-8 pt-8 border-t border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-400 text-[11px] md:text-xs font-bold uppercase tracking-widest">
                    <p>© {{ new Date().getFullYear() }} {{ $page.props.company.name }}</p>
                    <div class="flex items-center gap-4 md:gap-6">
                        <span class="tracking-tighter italic normal-case font-medium">{{ $page.props.company.address_short }}</span>
                    </div>
                </footer>
            </main>
        </div>
    </div>
</template>
