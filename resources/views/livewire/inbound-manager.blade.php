<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Barang Masuk (Inbound)</h2>
            <p class="text-sm text-slate-500 font-medium">Penerimaan barang dari supplier ke gudang</p>
        </div>
        <button wire:click="simulateScan" class="flex items-center gap-2 px-6 py-3 bg-indigo-100 text-indigo-700 rounded-2xl text-xs font-black hover:bg-indigo-200 transition-all border border-indigo-200 shadow-sm active:scale-95">
            <i class="ph-bold ph-scan text-lg"></i> SIMULATE BARCODE SCAN
        </button>
    </div>

    @if (session()->has('scan_message'))
        <div class="bg-indigo-600 text-white px-6 py-3 rounded-2xl mb-6 text-sm font-bold animate-bounce flex items-center gap-3">
            <i class="ph-bold ph-check"></i> {{ session('scan_message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <!-- Supplier Info -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="ph-fill ph-user-circle text-indigo-600 text-xl"></i> Informasi Supplier
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Supplier</label>
                            <select wire:model="supplier_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Transaksi</label>
                            <textarea wire:model="notes" rows="2" placeholder="Contoh: Barang titipan, Fragile, dll" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all resize-none"></textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">Tanggal Terima</label>
                        <input type="text" value="{{ now()->format('d M Y') }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-400 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="ph-fill ph-list-plus text-indigo-600 text-xl"></i> Daftar Barang
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Produk</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-24 text-center">Qty</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-40">Harga Beli</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-40 text-right">Subtotal</th>
                                <th class="pb-4 w-12 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($items as $index => $item)
                            <tr class="group">
                                <td class="py-5 pr-4">
                                    <select wire:model.live="items.{{ $index }}.product_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500">
                                        <option value="">Pilih Produk...</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }} ({{ $p->brand }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="py-5 pr-4">
                                    <input type="number" wire:model.live="items.{{ $index }}.qty" class="w-full bg-white border border-slate-200 rounded-xl px-3 py-2 text-sm font-black text-center outline-none focus:ring-2 focus:ring-indigo-500">
                                </td>
                                <td class="py-5 pr-4">
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-300">RP</span>
                                        <input type="number" wire:model.live="items.{{ $index }}.price" class="w-full bg-white border border-slate-200 rounded-xl pl-8 pr-3 py-2 text-sm font-black outline-none focus:ring-2 focus:ring-indigo-500">
                                    </div>
                                </td>
                                <td class="py-5 text-right font-black text-slate-800 text-sm">
                                    Rp {{ number_format($item['qty'] * (is_numeric($item['price']) ? $item['price'] : 0), 0, ',', '.') }}
                                </td>
                                <td class="py-5 text-center">
                                    <button wire:click="removeItem({{ $index }})" class="p-2 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all"><i class="ph ph-trash text-xl"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button wire:click="addItem" class="w-full mt-6 py-4 border-2 border-dashed border-slate-100 rounded-2xl text-slate-400 hover:border-indigo-400 hover:text-indigo-600 hover:bg-indigo-50/50 transition-all font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                    <i class="ph-bold ph-plus"></i> Tambah Baris Baru
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-indigo-900 text-white p-8 rounded-[2.5rem] shadow-2xl shadow-indigo-900/40 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
                <h3 class="text-indigo-300 text-[10px] font-black uppercase tracking-[0.2em] mb-8 border-b border-white/10 pb-4">Ringkasan Nilai PO</h3>
                
                <div class="mb-10">
                    <p class="text-indigo-400 text-[10px] font-black uppercase tracking-widest mb-2">Grand Total</p>
                    <p class="text-4xl font-black tracking-tighter">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>

                @if (session()->has('error'))
                    <div class="bg-rose-500/20 text-rose-200 p-3 rounded-xl border border-rose-500/30 text-[10px] font-bold mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex flex-col gap-3">
                    <button wire:click="save" class="w-full bg-white text-indigo-900 hover:bg-indigo-50 font-black py-4 rounded-2xl transition-all shadow-xl shadow-indigo-950/20 active:scale-95">
                        KONFIRMASI FINAL
                    </button>
                    <button class="w-full bg-white/5 text-indigo-300 hover:bg-white/10 font-bold py-3 rounded-xl transition-all text-sm">
                        SIMPAN DRAFT
                    </button>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="ph-fill ph-file-text text-indigo-600 text-lg"></i> Catatan
                </h3>
                <textarea rows="3" class="w-full bg-slate-50 border border-slate-100 rounded-2xl p-4 text-xs font-medium outline-none focus:ring-2 focus:ring-indigo-500 transition-all" placeholder="Tambahkan keterangan..."></textarea>
            </div>
        </div>
    </div>
</div>
