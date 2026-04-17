<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResponsiveTable from '@/Components/ResponsiveTable.vue';
import { Head, Link } from '@inertiajs/vue3';
import { PhPlus, PhTruck, PhCalendar, PhWarehouse, PhUser } from "@phosphor-icons/vue";

defineProps({
    deliveryOrders: Object
});
</script>

<template>
    <Head title="Barang Keluar" />

    <AuthenticatedLayout title="Barang Keluar">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 font-sans">
            <div>
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Pengeluaran Barang</h2>
                <p class="text-[11px] text-slate-500 font-bold mt-1">Surat Jalan & Distribusi Logistik</p>
            </div>
            <Link :href="route('barang-keluar.create')" class="btn-primary flex items-center justify-center gap-2">
                <PhPlus weight="bold" /> <span class="tracking-tight">Pengiriman Baru</span>
            </Link>
        </div>

        <ResponsiveTable :headers="['No. SJ', 'Customer', 'Warehouse', 'Tanggal', 'Status']" :items="deliveryOrders.data">
            <template #row="{ item }">
                <td class="px-8 py-5">
                    <span class="text-[10px] font-black text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg border border-indigo-100 uppercase tracking-wider">
                        {{ item.no_sj }}
                    </span>
                </td>
                <td class="px-8 py-5 text-sm font-black text-slate-800 tracking-tight">{{ item.customer?.nama }}</td>
                <td class="px-8 py-5 text-sm font-bold text-slate-600 tracking-tight">{{ item.warehouse?.nama }}</td>
                <td class="px-8 py-5 text-sm font-bold text-slate-500 tracking-tight">{{ new Date(item.tanggal).toLocaleDateString('id-ID') }}</td>
                <td class="px-8 py-5">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black border border-emerald-100 uppercase tracking-tighter">
                        {{ item.status }}
                    </span>
                </td>
                <td class="px-8 py-5 text-right">
                    <Link :href="route('barang-keluar.index')" class="p-2.5 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all active:scale-90 inline-flex">
                        <PhTruck :size="20" weight="bold" />
                    </Link>
                </td>
            </template>

            <template #mobile-card="{ item }">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <PhTruck :size="20" weight="fill" />
                        </div>
                        <div>
                            <div class="font-black text-slate-800 tracking-tight">{{ item.no_sj }}</div>
                            <div class="text-[10px] font-bold text-amber-600 uppercase tracking-widest">{{ item.customer?.nama || '-' }}</div>
                        </div>
                    </div>
                    <Link :href="route('barang-keluar.index')" class="p-2 text-slate-400 hover:text-indigo-600">
                        <PhTruck :size="20" weight="bold" />
                    </Link>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                    <div class="flex items-start gap-2">
                        <PhWarehouse :size="14" class="text-slate-300 mt-0.5" />
                        <p class="text-[11px] font-bold text-slate-600 truncate">{{ item.warehouse?.nama }}</p>
                    </div>
                    <div class="flex items-start gap-2 justify-end text-right">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 text-[9px] font-black uppercase tracking-tighter">
                            {{ item.status }}
                        </span>
                    </div>
                </div>
            </template>

            <template #pagination>
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest italic">Logs {{ deliveryOrders.from || 0 }}-{{ deliveryOrders.to || 0 }} of {{ deliveryOrders.total }}</p>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition active:scale-95 disabled:opacity-50">Prev</button>
                        <button class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition active:scale-95">Next</button>
                    </div>
                </div>
            </template>
        </ResponsiveTable>
    </AuthenticatedLayout>
</template>
