<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import StatCard from '@/Components/StatCard.vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    PhStack, 
    PhArrowDownLeft, 
    PhArrowUpRight, 
    PhWarningCircle, 
    PhClockCounterClockwise 
} from "@phosphor-icons/vue";
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Filler
} from 'chart.js';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    PointElement,
    CategoryScale,
    LinearScale,
    Filler
);

const chartData = {
    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
    datasets: [
        {
            label: 'Barang Masuk',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            borderColor: '#4f46e5',
            data: [40, 39, 10, 40, 39, 80, 40],
            fill: true,
            tension: 0.4
        },
        {
            label: 'Barang Keluar',
            backgroundColor: 'rgba(245, 158, 11, 0.1)',
            borderColor: '#f59e0b',
            data: [20, 20, 30, 10, 50, 40, 70],
            fill: true,
            tension: 0.4
        }
    ]
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: false
        }
    },
    scales: {
        y: {
            beginAtZero: true,
            grid: {
                display: false
            }
        },
        x: {
            grid: {
                display: false
            }
        }
    }
};

defineProps({
    stats: Object,
    recentTransactions: Array
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout title="Dashboard">
        <!-- Stat Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
            <StatCard 
                title="Total Stok" 
                value="12,450" 
                :icon="PhStack" 
                trend="+2.4%" 
                trend-label="dari bulan lalu" 
            />
            <StatCard 
                title="Masuk Hari Ini" 
                value="24" 
                :icon="PhArrowDownLeft" 
                icon-color="text-emerald-600"
                icon-bg="bg-emerald-50"
                icon-bg-hover="group-hover:bg-emerald-600"
                footer-label="5 Supplier terverifikasi"
            />
            <StatCard 
                title="Keluar Hari Ini" 
                value="18" 
                :icon="PhArrowUpRight" 
                icon-color="text-amber-600"
                icon-bg="bg-amber-50"
                icon-bg-hover="group-hover:bg-amber-600"
                footer-label="Menuju 12 Customer"
            />
            <StatCard 
                title="Invoice Pending" 
                value="45" 
                unit="Jt"
                :icon="PhWarningCircle" 
                icon-color="text-rose-600"
                icon-bg="bg-rose-50"
                icon-bg-hover="group-hover:bg-rose-600"
                footer-label="Butuh perhatian segera"
                :footer-pulse="true"
            />
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8 mb-8">
            <!-- Chart Section -->
            <div class="lg:col-span-2 bg-white border border-slate-200 rounded-[2rem] shadow-sm p-6 md:p-8">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-[0.2em]">Aktivitas Mingguan</h2>
                    <div class="flex gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></span>
                            <span class="text-xs font-bold text-slate-500 tracking-tight uppercase">Masuk</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 bg-amber-500 rounded-full"></span>
                            <span class="text-xs font-bold text-slate-500 tracking-tight uppercase">Keluar</span>
                        </div>
                    </div>
                </div>
                <div class="h-60 md:h-80">
                    <Line :data="chartData" :options="chartOptions" />
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden flex flex-col">
                <div class="px-6 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/30">
                    <h2 class="text-sm font-bold text-slate-800 uppercase tracking-[0.2em] flex items-center gap-3">
                        <PhClockCounterClockwise :size="20" weight="bold" class="text-indigo-600" />
                        Aktivitas
                    </h2>
                </div>
                <div class="flex-1">
                    <div class="divide-y divide-slate-100 italic">
                        <div class="p-5 hover:bg-slate-50 transition duration-300 flex items-center justify-between gap-4">
                            <div class="truncate">
                                <p class="font-black text-slate-900 text-sm tracking-tight truncate">SJ-2026-001</p>
                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 truncate">PT Maju Jaya</p>
                            </div>
                            <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-[10px] font-black border border-amber-100 uppercase tracking-tighter">
                                Keluar
                            </span>
                        </div>
                        <div class="p-5 hover:bg-slate-50 transition duration-300 flex items-center justify-between gap-4">
                            <div class="truncate">
                                <p class="font-black text-slate-900 text-sm tracking-tight truncate">PO-2026-005</p>
                                <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-0.5 truncate">CV Makmur Abadi</p>
                            </div>
                            <span class="shrink-0 inline-flex items-center px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-[10px] font-black border border-emerald-100 uppercase tracking-tighter">
                                Masuk
                            </span>
                        </div>
                    </div>
                </div>
                <div class="p-6 bg-slate-50/30 border-t border-slate-100 text-center">
                    <Link :href="route('barang-masuk.index')" class="text-[11px] text-indigo-600 font-black hover:text-indigo-700 underline underline-offset-8 decoration-2 uppercase tracking-[0.2em]">LIHAT SEMUA</Link>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
