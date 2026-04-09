@extends('layouts.app')

@section('title', 'Dashboard')
@section('header', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-8">
    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Stok</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ number_format($stats['total_stock'], 0, ',', '.') }}</h3>
            </div>
            <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-500">
                <i class="ph ph-stack text-2xl"></i>
            </div>
        </div>
        <p class="text-xs text-slate-500">Unit terdaftar di gudang</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Masuk Hari Ini</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['in_today'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-500">
                <i class="ph ph-arrow-down-left text-2xl"></i>
            </div>
        </div>
        <p class="text-xs text-slate-500 font-medium italic">Transaksi inbound</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Keluar Hari Ini</p>
                <h3 class="text-3xl font-black text-slate-800 mt-1">{{ $stats['out_today'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600 group-hover:bg-amber-600 group-hover:text-white transition-colors duration-500">
                <i class="ph ph-arrow-up-right text-2xl"></i>
            </div>
        </div>
        <p class="text-xs text-slate-500 font-medium italic">Transaksi outbound</p>
    </div>

    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
        <div class="flex justify-between items-start mb-4">
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Stok Menipis</p>
                <h3 class="text-3xl font-black text-rose-500 mt-1">{{ $stats['low_stock_count'] }}</h3>
            </div>
            <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 group-hover:bg-rose-600 group-hover:text-white transition-colors duration-500">
                <i class="ph ph-warning-circle text-2xl"></i>
            </div>
        </div>
        <a href="{{ route('inventory.index') }}" class="text-xs text-rose-600 font-bold hover:underline underline-offset-4">Lihat Inventory →</a>
    </div>
</div>

<div class="bg-white border border-slate-200 rounded-3xl shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-widest flex items-center gap-2">
            <i class="ph ph-clock-counter-clockwise text-indigo-600 text-lg"></i>
            Aktivitas Terakhir
        </h2>
        <button class="text-xs text-indigo-600 font-bold hover:text-indigo-700 underline underline-offset-4 decoration-2">LIHAT SEMUA</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead class="bg-white border-b border-slate-200">
                <tr>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">ID Transaksi</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Mitra</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tipe</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="hidden sm:table-cell px-6 py-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($recentTransactions as $tx)
                <tr class="hover:bg-slate-50 transition colors duration-300 group cursor-pointer" onclick="window.location='{{ route('transaction.show', $tx->id) }}'">
                    <td class="px-6 py-4 font-black text-slate-900 text-sm">
                        <span class="group-hover:text-indigo-600 transition-colors">#{{ str_pad($tx->id, 5, '0', STR_PAD_LEFT) }}</span>
                    </td>
                    <td class="px-6 py-4 text-slate-600 font-semibold text-sm">{{ $tx->mitra_name }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg {{ $tx->type === 'Masuk' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-amber-50 text-amber-700 border-amber-200' }} text-[10px] font-bold border uppercase tracking-tighter">
                            {{ $tx->type }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 text-xs">{{ $tx->date }}</td>
                    <td class="hidden sm:table-cell px-6 py-4 text-right font-bold text-slate-800 text-sm">
                        Rp {{ number_format($tx->total_amount, 0, ',', '.') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-slate-400 text-sm">Belum ada aktivitas hari ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
