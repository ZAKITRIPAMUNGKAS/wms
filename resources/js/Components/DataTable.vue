<script setup>
defineProps({
    headers: Array,
    items: Array,
    loading: Boolean
});
</script>

<template>
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden font-sans">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/80 border-b border-slate-100">
                    <tr>
                        <th v-for="header in headers" :key="header" class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider">
                            {{ header }}
                        </th>
                        <th class="px-6 py-4 text-xs font-semibold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <tr v-if="items.length === 0" class="italic">
                        <td :colspan="headers.length + 1" class="px-6 py-10 text-center text-slate-400">
                            Tidak ada data ditemukan
                        </td>
                    </tr>
                    <tr v-for="(item, index) in items" :key="index" class="hover:bg-slate-50/50 transition-colors group italic">
                        <slot name="row" :item="item" />
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex justify-between items-center">
            <slot name="pagination" />
        </div>
    </div>
</template>
