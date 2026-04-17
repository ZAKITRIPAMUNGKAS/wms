<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import ResponsiveTable from '@/Components/ResponsiveTable.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link } from '@inertiajs/vue3';
import { 
    PhMagnifyingGlass, 
    PhFaders, 
    PhDownloadSimple, 
    PhWhatsappLogo, 
    PhPackage,
    PhFileText,
    PhCalendar,
    PhUser,
    PhCheckCircle,
    PhWarningCircle,
    PhXCircle
} from "@phosphor-icons/vue";
import { ref } from 'vue';

const props = defineProps({
    invoices: Object,
});

const showPreview = ref(false);
const selectedInvoice = ref(null);

const openPreview = (invoice) => {
    selectedInvoice.value = invoice;
    showPreview.value = true;
};

const getStatusClass = (status) => {
    switch (status) {
        case 'lunas': return 'bg-emerald-50 text-emerald-700 border-emerald-100';
        case 'partial': return 'bg-amber-50 text-amber-700 border-amber-100';
        default: return 'bg-rose-50 text-rose-700 border-rose-100';
    }
};

const getStatusDotClass = (status) => {
    switch (status) {
        case 'lunas': return 'bg-emerald-500';
        case 'partial': return 'bg-amber-500';
        default: return 'bg-rose-500';
    }
};
</script>

<template>
    <Head title="Invoice" />

    <AuthenticatedLayout title="Invoice">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 font-sans">
            <div>
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Manajemen Invoice</h2>
                <p class="text-[11px] text-slate-500 font-bold mt-1">Tagihan Penjualan & Status Pembayaran</p>
            </div>
            <div class="flex gap-2">
                <div class="relative flex-1 sm:w-64">
                    <PhMagnifyingGlass :size="16" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" />
                    <input type="text" placeholder="Cari invoice..." class="input-base !pl-10 !py-2 text-xs">
                </div>
                <button class="p-2.5 bg-white border border-slate-200 rounded-xl text-slate-500 hover:bg-slate-50 transition active:scale-95">
                    <PhFaders :size="20" weight="bold" />
                </button>
            </div>
        </div>

        <ResponsiveTable :headers="['No. Invoice', 'Customer', 'Tanggal & Tempo', 'Total Tagihan', 'Status']" :items="invoices.data">
            <template #row="{ item }">
                <td class="px-8 py-5">
                    <div class="font-black text-slate-800 tracking-tight">{{ item.no_invoice }}</div>
                    <div class="text-[10px] text-slate-400 font-bold mt-0.5 uppercase tracking-widest">Ref: {{ item.delivery_order?.no_sj }}</div>
                </td>
                <td class="px-8 py-5 text-sm font-black text-slate-700 tracking-tight">{{ item.delivery_order?.customer?.nama }}</td>
                <td class="px-8 py-5">
                    <div class="text-[11px] font-bold text-slate-600 tracking-tight">{{ new Date(item.tanggal).toLocaleDateString('id-ID') }}</div>
                    <div class="text-[10px] text-rose-500 font-black uppercase tracking-wider mt-0.5">Tempo: {{ new Date(item.due_date).toLocaleDateString('id-ID') }}</div>
                </td>
                <td class="px-8 py-5 font-black text-slate-800 tracking-tight text-right">Rp {{ Number(item.total).toLocaleString('id-ID') }}</td>
                <td class="px-8 py-5">
                    <span :class="['inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black border uppercase tracking-tighter', getStatusClass(item.status)]">
                        <div :class="['w-1.5 h-1.5 rounded-full', getStatusDotClass(item.status)]"></div> {{ item.status }}
                    </span>
                    <div v-if="item.status === 'partial'" class="text-[9px] text-slate-400 mt-1 font-bold italic">Sisa: Rp {{ (item.total - item.paid_amount).toLocaleString('id-ID') }}</div>
                </td>
                <td class="px-8 py-5 text-right">
                    <button @click="openPreview(item)" class="p-2.5 text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all active:scale-90 font-black text-xs uppercase tracking-widest">Detail</button>
                </td>
            </template>

            <template #mobile-card="{ item }">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <PhFileText :size="20" weight="fill" />
                        </div>
                        <div>
                            <div class="font-black text-slate-800 tracking-tight">{{ item.no_invoice }}</div>
                            <div class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">{{ item.delivery_order?.customer?.nama }}</div>
                        </div>
                    </div>
                    <span :class="['px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-tighter border', getStatusClass(item.status)]">
                        {{ item.status }}
                    </span>
                </div>
                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-50">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Tagihan</p>
                        <p class="text-sm font-black text-slate-900 tracking-tight">Rp {{ Number(item.total).toLocaleString('id-ID') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jatuh Tempo</p>
                        <p class="text-[11px] font-bold text-rose-500 tracking-tight">{{ new Date(item.due_date).toLocaleDateString('id-ID') }}</p>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-50 flex justify-end">
                    <button @click="openPreview(item)" class="text-indigo-600 font-black text-[10px] uppercase tracking-[0.2em] px-4 py-2 bg-indigo-50 rounded-lg active:scale-95 transition">Lihat Detail</button>
                </div>
            </template>

            <template #pagination>
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Logs {{ invoices.from || 0 }}-{{ invoices.to || 0 }} of {{ invoices.total }}</p>
                    <div class="flex gap-2">
                        <button class="px-4 py-2 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition active:scale-95 disabled:opacity-50">Prev</button>
                        <button class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition active:scale-95">Next</button>
                    </div>
                </div>
            </template>
        </ResponsiveTable>

        <Modal :show="showPreview" title="Detail Invoice" @close="showPreview = false">
            <div class="bg-slate-50 p-4 md:p-10 max-h-[70vh] overflow-y-auto">
                <div class="bg-white w-full max-w-2xl mx-auto p-6 md:p-12 shadow-sm border border-slate-100 relative rounded-2xl">
                    <div v-if="selectedInvoice?.status !== 'lunas'" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 -rotate-12 opacity-[0.03] text-[5rem] md:text-[8rem] font-black uppercase text-rose-500 pointer-events-none tracking-widest leading-none text-center select-none">
                        UNPAID
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start gap-6 border-b-2 border-slate-50 pb-8 mb-8">
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200">
                                    <PhPackage :size="24" weight="fill" class="text-white" />
                                </div>
                                <h1 class="text-xl font-black text-slate-900 tracking-tight">{{ $page.props.company.name }}</h1>
                            </div>
                            <div class="text-[11px] font-bold text-slate-400 space-y-1">
                                <p>{{ $page.props.company.address }}</p>
                                <p class="text-indigo-600">Telp: {{ $page.props.company.phone_primary }}</p>
                            </div>
                        </div>
                        <div class="md:text-right">
                            <h2 class="text-3xl font-black text-indigo-600 tracking-tighter uppercase mb-2">INVOICE</h2>
                            <p class="text-sm font-black text-slate-800"># {{ selectedInvoice?.no_invoice }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                        <div class="space-y-4">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-l-4 border-indigo-600 pl-3">Tagihan Kepada:</p>
                            <div>
                                <h3 class="text-sm font-black text-slate-900 uppercase tracking-tight">{{ selectedInvoice?.delivery_order?.customer?.nama }}</h3>
                                <p class="text-xs font-bold text-slate-500 mt-2 leading-relaxed italic">{{ selectedInvoice?.delivery_order?.customer?.alamat }}</p>
                            </div>
                        </div>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 space-y-4">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status Pembayaran:</p>
                            <div class="flex items-center gap-2">
                                <span :class="['text-xl font-black tracking-tight uppercase', selectedInvoice?.status === 'lunas' ? 'text-emerald-600' : 'text-rose-600']">
                                    {{ selectedInvoice?.status }}
                                </span>
                                <PhCheckCircle v-if="selectedInvoice?.status === 'lunas'" :size="20" weight="fill" class="text-emerald-500" />
                                <PhWarningCircle v-else :size="20" weight="fill" class="text-rose-500" />
                            </div>
                        </div>
                    </div>

                    <div class="pt-8 border-t-2 border-slate-50">
                        <div class="flex justify-end">
                            <div class="w-full max-w-xs space-y-3">
                                <div class="flex justify-between items-center px-6 py-4 bg-slate-900 text-white rounded-2xl shadow-xl">
                                    <span class="text-[10px] font-black uppercase tracking-[0.2em]">TOTAL</span>
                                    <span class="text-xl font-black">Rp {{ Number(selectedInvoice?.total).toLocaleString('id-ID') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sticky bottom-0 bg-white/80 backdrop-blur-md p-6 border-t border-slate-100 flex flex-col sm:flex-row justify-end gap-3 mt-auto">
                <button class="bg-[#25D366] hover:bg-[#1da851] text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-200 active:scale-95 w-full sm:w-auto">
                    <PhWhatsappLogo :size="18" weight="bold" /> Kirim WhatsApp
                </button>
                <a v-if="selectedInvoice" :href="route('invoices.pdf', selectedInvoice.id)" target="_blank" class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition flex items-center justify-center gap-2 shadow-sm active:scale-95 w-full sm:w-auto">
                    <PhDownloadSimple :size="18" weight="bold" /> Download PDF
                </a>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>
