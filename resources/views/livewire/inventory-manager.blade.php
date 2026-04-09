<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Status Inventori</h2>
            <p class="text-sm text-slate-500 font-medium">Monitor stok barang secara real-time</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="relative w-full md:w-64">
                <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
                <input type="text" wire:model.live="search" placeholder="Cari barang..." 
                    class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
            </div>
            <select wire:model.live="filter" class="bg-white border border-slate-200 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer">
                <option value="all">Semua Stok</option>
                <option value="low_stock">Stok Menipis (1-5)</option>
                <option value="out_of_stock">Stok Habis (0)</option>
            </select>
        </div>
    </div>

    <!-- Inventory Stats Summary -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-indigo-600 p-6 rounded-[2rem] text-white shadow-lg shadow-indigo-100 flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black uppercase tracking-widest opacity-70">Total Produk</p>
                <h4 class="text-3xl font-black mt-1">{{ \App\Models\Product::count() }}</h4>
            </div>
            <i class="ph ph-package text-4xl opacity-50"></i>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stok Menipis</p>
                <h4 class="text-3xl font-black text-rose-500 mt-1">{{ \App\Models\Product::whereBetween('stock', [1, 5])->count() }}</h4>
            </div>
            <i class="ph ph-warning-circle text-4xl text-rose-200"></i>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-200 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Stok Habis</p>
                <h4 class="text-3xl font-black text-slate-800 mt-1">{{ \App\Models\Product::where('stock', '<=', 0)->count() }}</h4>
            </div>
            <i class="ph ph-x-circle text-4xl text-slate-200"></i>
        </div>
    </div>

    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">IDENTITAS BARANG</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">KATEGORI / INFO</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">KONDISI STOK</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">TOTAL UNIT</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">VALUASI STOK</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($products as $product)
                    <tr class="hover:bg-slate-50 transition-all duration-300">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                                    <i class="ph ph-file-text text-2xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900">{{ $product->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mt-0.5">ID: #PRD-{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-md text-[10px] font-black uppercase w-fit mb-1">{{ $product->brand ?? 'No Brand' }}</span>
                                <span class="text-xs text-slate-500 font-medium">{{ $product->type ?? 'General' }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            @if($product->stock <= 0)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-rose-50 text-rose-600 rounded-full text-[10px] font-black border border-rose-100">
                                    <div class="w-1.5 h-1.5 rounded-full bg-rose-600 animate-pulse"></div> HABIS
                                </span>
                            @elseif($product->stock <= 5)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-amber-50 text-amber-600 rounded-full text-[10px] font-black border border-amber-100">
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-600"></div> MENIPIS
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-black border border-emerald-100">
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-600"></div> TERSEDIA
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 font-black text-slate-900 text-base">
                            {{ $product->stock }} <span class="text-xs text-slate-400 font-bold uppercase ml-1">{{ $product->unit }}</span>
                        </td>
                        <td class="px-8 py-6 text-right font-black text-slate-900">
                            Rp {{ number_format($product->stock * $product->price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-16 text-center text-slate-400 font-medium italic">Data inventori tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
        <div class="px-8 py-6 bg-slate-50 border-t border-slate-100">
            {{ $products->links() }}
        </div>
        @endif
    </div>
</div>
