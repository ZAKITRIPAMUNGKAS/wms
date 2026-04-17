<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResponsiveTable from '@/Components/ResponsiveTable.vue';
import { Head } from '@inertiajs/vue3';
import { 
    PhPrinter, 
    PhFileXls, 
    PhTrendUp, 
    PhListNumbers,
    PhArrowCircleUp,
    PhPackage,
    PhCalendar,
    PhUser,
    PhChartLine,
    PhFileText
} from "@phosphor-icons/vue";
import { ref } from 'vue';

const props = defineProps({
    reportData: Object,
    summary: Object
});

const reportType = ref('Laporan Barang Keluar');
const startDate = ref('2026-04-01');
const endDate = ref('2026-04-30');

// Mock data for table
const mockItems = [
    { 
        id: 1, 
        tgl: '12 Apr', 
        ref: 'SJ-2026-001', 
        customer: 'PT Maju Jaya', 
        product: 'Kabel UTP Cat 6', 
        qty: 10, 
        total: 15000000 
    },
    { 
        id: 2, 
        tgl: '14 Apr', 
        ref: 'SJ-2026-002', 
        customer: 'PT Berkah', 
        product: 'Router Mikrotik', 
        qty: 5, 
        total: 7500000 
    }
];
</script>

<template>
    <Head title="Laporan" />

    <AuthenticatedLayout title="Laporan">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 font-sans">
            <div>
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Reporting & Analytics</h2>
                <p class="text-[11px] text-slate-500 font-bold mt-1">Rekapitulasi Data Operasional</p>
            </div>
            <div class="flex gap-2">
                <button class="btn-secondary !py-2.5 flex items-center gap-2">
                    <PhPrinter :size="18" weight="bold" /> <span class="tracking-tight hidden sm:inline">Cetak</span>
                </button>
                <button class="bg-[#107c41] hover:bg-[#0c6132] text-white px-5 py-2.5 rounded-xl font-black text-xs uppercase tracking-widest transition flex items-center gap-2 shadow-lg shadow-emerald-100 active:scale-95">
                    <PhFileXls :size="18" weight="bold" /> <span class="tracking-tight hidden sm:inline">Excel</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-8 font-sans">
            <!-- Filter Section -->
            <div class="lg:col-span-8 bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Jenis Laporan</label>
                        <select v-model="reportType" class="input-base font-black text-indigo-600 appearance-none">
                            <option>Laporan Barang Keluar</option>
                            <option>Laporan Barang Masuk</option>
                            <option>Laporan Stok Gudang</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Dari</label>
                        <input type="date" v-model="startDate" class="input-base font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Sampai</label>
                        <input type="date" v-model="endDate" class="input-base font-bold">
                    </div>
                </div>
            </div>
            <!-- Quick Actions/Stats -->
            <div class="lg:col-span-4 bg-indigo-600 rounded-3xl p-8 text-white relative overflow-hidden group shadow-xl shadow-indigo-100">
                <PhChartLine :size="120" weight="fill" class="absolute -bottom-4 -right-4 text-white opacity-10 group-hover:scale-110 transition-transform duration-700" />
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-widest text-indigo-200 mb-2">Total Akumulasi</p>
                    <h3 class="text-3xl font-black tracking-tight mb-1">Rp 185.0M</h3>
                    <p class="text-[10px] font-bold text-indigo-100/60 uppercase tracking-wider italic">Periode: April 2026</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden font-sans">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center gap-3">
                <div class="w-1.5 h-6 bg-indigo-600 rounded-full"></div>
                <h3 class="font-black text-slate-800 tracking-tight text-sm uppercase tracking-widest">Rincian Data Transaksi</h3>
            </div>
            
            <ResponsiveTable :headers="['Tgl', 'Ref', 'Customer', 'Produk', 'Qty', 'Nilai']" :items="mockItems">
                <template #row="{ item }">
                    <td class="px-8 py-5 text-[11px] font-bold text-slate-400 uppercase tracking-wider">{{ item.tgl }}</td>
                    <td class="px-8 py-5 font-black text-slate-800 tracking-tight">{{ item.ref }}</td>
                    <td class="px-8 py-5 text-sm font-black text-slate-700 tracking-tight underline decoration-indigo-100 decoration-2 underline-offset-4">{{ item.customer }}</td>
                    <td class="px-8 py-5 text-xs font-bold text-slate-500 italic">{{ item.product }}</td>
                    <td class="px-8 py-5 text-center font-black text-indigo-600 tracking-tight">{{ item.qty }}</td>
                    <td class="px-8 py-5 text-right font-black text-slate-900 tracking-tight">Rp {{ item.total.toLocaleString('id-ID') }}</td>
                </template>

                <template #mobile-card="{ item }">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center text-slate-600">
                                <PhFileText :size="20" weight="fill" />
                            </div>
                            <div>
                                <div class="font-black text-slate-800 tracking-tight">{{ item.ref }}</div>
                                <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ item.tgl }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Total</p>
                            <p class="text-sm font-black text-indigo-600 tracking-tight">Rp {{ (item.total/1000000).toFixed(1) }}M</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Customer</p>
                            <p class="text-xs font-black text-slate-700 tracking-tight truncate">{{ item.customer }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Qty</p>
                            <p class="text-xs font-black text-slate-900 tracking-tight">{{ item.qty }} <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Items</span></p>
                        </div>
                    </div>
                </template>
            </ResponsiveTable>
            
            <!-- Custom Footer for Report -->
            <div class="bg-slate-900 text-white p-8 font-sans">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-6">
                    <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 italic">Akumulasi Seluruh Data Berdasarkan Filter</p>
                    <div class="flex items-center gap-8 md:gap-16">
                        <div class="text-center sm:text-right">
                            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-1">Total Qty</p>
                            <p class="text-4xl font-black tracking-tighter">125</p>
                        </div>
                        <div class="text-center sm:text-right">
                            <p class="text-[10px] font-black uppercase tracking-widest text-indigo-400 mb-1">Total Nilai</p>
                            <p class="text-4xl font-black tracking-tighter">Rp 185.0M</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
