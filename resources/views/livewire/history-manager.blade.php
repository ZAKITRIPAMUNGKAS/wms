<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 uppercase tracking-widest no-print">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Laporan Transaksi</h2>
            <p class="text-[10px] text-slate-500 font-black">History logistik masuk dan keluar</p>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="resetFilters" class="text-xs text-slate-400 font-bold hover:text-rose-500 transition-colors">RESET FILTER</button>
            <button onclick="window.print()" class="bg-slate-900 border border-slate-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 hover:bg-slate-800 transition-all">
                <i class="ph ph-printer"></i> Cetak Laporan
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm p-6 mb-8 no-print">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="relative">
                <label class="block text-[9px] font-black text-slate-400 mb-2 tracking-widest uppercase">Cari Mitra / ID</label>
                <i class="ph ph-magnifying-glass absolute left-4 top-[38px] text-slate-400"></i>
                <input type="text" wire:model.live="search" class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-11 pr-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 mb-2 tracking-widest uppercase">Tipe Transaksi</label>
                <select wire:model.live="type" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
                    <option value="all">Semua Tipe</option>
                    <option value="Masuk">Barang Masuk</option>
                    <option value="Keluar">Barang Keluar</option>
                </select>
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 mb-2 tracking-widest uppercase">Dari Tanggal</label>
                <input type="date" wire:model.live="date_from" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
            </div>
            <div>
                <label class="block text-[9px] font-black text-slate-400 mb-2 tracking-widest uppercase">Sampai Tanggal</label>
                <input type="date" wire:model.live="date_to" class="w-full bg-slate-50 border border-slate-100 rounded-2xl px-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all">
            </div>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden border-t-4 border-t-indigo-500">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">ID TRANSAKSI</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">MITRA / SUPPLIER / CUSTOMER</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">TANGGAL</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">TIPE</th>
                        <th class="px-8 py-5 text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">TOTAL NILAI (RP)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 font-sans">
                    @forelse($transactions as $tx)
                    <tr class="hover:bg-indigo-50/30 transition-all duration-300 group cursor-pointer" onclick="window.location='{{ route('transaction.show', $tx->id) }}'">
                        <td class="px-8 py-6">
                            <span class="text-sm font-black text-slate-900 group-hover:text-indigo-600">#{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </td>
                        <td class="px-8 py-6">
                            <p class="text-sm font-bold text-slate-800">{{ $tx->mitra_name }}</p>
                            <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">TERVERIFIKASI</p>
                        </td>
                        <td class="px-8 py-6 text-xs text-slate-500 font-medium">
                            {{ date('d/m/Y', strtotime($tx->date)) }}
                        </td>
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[9px] font-black border uppercase tracking-widest {{ $tx->type === 'Masuk' ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-amber-50 text-amber-600 border-amber-100' }}">
                                {{ $tx->type }}
                            </span>
                        </td>
                        <td class="px-8 py-6 text-right text-sm font-black text-slate-900">
                            {{ number_format($tx->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center text-slate-400 font-medium italic">Data transaksi tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transactions->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 no-print">
            {{ $transactions->links() }}
        </div>
        @endif
    </div>

    <style>
        @media print {
            aside, header, .no-print {
                display: none !important;
            }
            body, main {
                background: white !important;
                height: auto !important;
                overflow: visible !important;
            }
            main > div {
                padding: 0 !important;
                margin: 0 !important;
                max-width: none !important;
            }
            .bg-white {
                border: none !important;
                box-shadow: none !important;
            }
            table {
                font-size: 10pt !important;
            }
        }
    </style>
</div>
