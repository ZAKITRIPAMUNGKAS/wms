<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Barang Keluar (Outbound)</h2>
            <p class="text-sm text-slate-500 font-medium">Pengiriman barang ke customer / pemesan</p>
        </div>
        <button wire:click="simulateScan" class="flex items-center gap-2 px-6 py-3 bg-amber-100 text-amber-700 rounded-2xl text-xs font-black hover:bg-amber-200 transition-all border border-amber-200 shadow-sm active:scale-95">
            <i class="ph-bold ph-scan text-lg"></i> SCAN QR CODE
        </button>
    </div>

    @if (session()->has('scan_message'))
        <div class="bg-amber-500 text-white px-6 py-3 rounded-2xl mb-6 text-sm font-bold animate-pulse flex items-center gap-3">
            <i class="ph-bold ph-check"></i> {{ session('scan_message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Info -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="ph-fill ph-handshake text-amber-600 text-xl"></i> Informasi Customer
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Customer</label>
                            <select wire:model="customer_id" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all cursor-pointer">
                                <option value="">-- Pilih Customer --</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Pengiriman</label>
                            <textarea wire:model="notes" rows="2" placeholder="Contoh: Kirim via JNE, Urgent, dll" class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 transition-all resize-none"></textarea>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 ml-1">No. Surat Jalan</label>
                        <input type="text" value="SJ/{{ now()->format('Ymd') }}/{{ rand(100,999) }}" readonly class="w-full bg-slate-100 border border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-400 cursor-not-allowed">
                    </div>
                </div>
            </div>

            <!-- Items -->
            <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest mb-6 flex items-center gap-2">
                    <i class="ph-fill ph-shopping-cart text-amber-600 text-xl"></i> Barang yang Dikirim
                </h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b border-slate-100">
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Produk</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-24 text-center">Qty</th>
                                <th class="pb-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] w-40 text-right">Harga Satuan</th>
                                <th class="pb-4 w-12 text-center"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach($items as $index => $item)
                            <tr class="group">
                                <td class="py-5 pr-4">
                                    <select wire:model.live="items.{{ $index }}.product_id" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-amber-500">
                                        <option value="">Pilih Produk...</option>
                                        @foreach($products as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->stock }})</option>
                                        @endforeach
                                    </select>
                                    @if($item['product_id'])
                                        <p class="text-[10px] mt-1 text-slate-400 ml-1">Maksimal stok tersedia: <span class="font-bold {{ $item['max_stock'] < 10 ? 'text-rose-500' : 'text-slate-600' }}">{{ $item['max_stock'] }}</span></p>
                                    @endif
                                </td>
                                <td class="py-5 pr-4">
                                    <input type="number" wire:model.live="items.{{ $index }}.qty" class="w-full bg-white border {{ $item['qty'] > $item['max_stock'] ? 'border-rose-500 ring-2 ring-rose-500/20' : 'border-slate-200' }} rounded-xl px-3 py-2 text-sm font-black text-center outline-none focus:ring-2 focus:ring-amber-500">
                                    @if($item['qty'] > $item['max_stock'])
                                        <p class="text-[9px] text-rose-500 font-bold mt-1 text-center">STOK KURANG!</p>
                                    @endif
                                </td>
                                <td class="py-5 text-right font-black text-slate-800 text-sm">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </td>
                                <td class="py-5 text-center">
                                    <button wire:click="removeItem({{ $index }})" class="p-2 text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all"><i class="ph ph-trash text-xl"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button wire:click="addItem" class="w-full mt-6 py-4 border-2 border-dashed border-slate-100 rounded-2xl text-slate-400 hover:border-amber-400 hover:text-amber-600 hover:bg-amber-50/50 transition-all font-bold text-xs uppercase tracking-widest flex items-center justify-center gap-2">
                    <i class="ph-bold ph-plus"></i> Tambah Item Lain
                </button>
            </div>
        </div>

        <div class="space-y-6">
            <div class="bg-amber-600 text-white p-8 rounded-[2.5rem] shadow-2xl shadow-amber-600/40 relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <h3 class="text-white/70 text-[10px] font-black uppercase tracking-[0.2em] mb-8 border-b border-white/20 pb-4 text-center">Preview Nilai Keluar</h3>
                
                <div class="text-center mb-10">
                    <p class="text-white/60 text-[10px] font-black uppercase tracking-widest mb-2">Total Estimasi</p>
                    <p class="text-4xl font-black tracking-tighter">Rp {{ number_format(collect($items)->sum(fn($i) => $i['qty'] * $i['price']), 0, ',', '.') }}</p>
                </div>

                @if (session()->has('error'))
                    <div class="bg-white/10 text-white p-3 rounded-xl border border-white/20 text-[10px] font-bold mb-6 text-center">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex flex-col gap-3">
                    <button wire:click="save" class="w-full bg-white text-amber-700 hover:bg-amber-50 font-black py-4 rounded-2xl transition-all shadow-xl shadow-amber-950/20 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed" {{ $has_error ? 'disabled' : '' }}>
                        PROSES PENGIRIMAN
                    </button>
                    <p class="text-[9px] text-center text-white/50 font-medium">Dengan mengklik tombol diatas, stok akan otomatis terpotong di database.</p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
                <h3 class="text-xs font-black text-slate-800 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <i class="ph-fill ph-truck text-amber-600 text-lg"></i> Ekspedisi
                </h3>
                <select class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-xs font-bold outline-none focus:ring-2 focus:ring-amber-500">
                    <option>Internal Delivery</option>
                    <option>JNE Express</option>
                    <option>J&T Express</option>
                    <option>SiCepat</option>
                </select>
            </div>
        </div>
    </div>
</div>
