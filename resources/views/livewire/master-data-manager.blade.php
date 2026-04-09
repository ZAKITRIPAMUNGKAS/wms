<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Manajemen Data Master</h2>
            <p class="text-sm text-slate-500 font-medium">Pengaturan database entitas logistik Anda</p>
        </div>
        <button wire:click="openModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 shadow-lg shadow-indigo-200 transition-all active:scale-95">
            <i class="ph-bold ph-plus"></i>
            Tambah Data Baru
        </button>
    </div>

    <!-- Toolbar: Tabs & Search -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-2 p-1.5 bg-slate-200/60 rounded-2xl w-fit border border-slate-200/50 backdrop-blur-sm">
            @foreach(['Produk', 'Supplier', 'Customer', 'Gudang'] as $t)
            <button wire:click="setTab('{{ $t }}')" 
                class="px-6 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 {{ $tab === $t ? 'bg-white text-indigo-600 shadow-sm ring-1 ring-slate-200/50' : 'text-slate-500 hover:text-slate-800 hover:bg-white/50' }}">
                {{ $t }}
            </button>
            @endforeach
        </div>

        <div class="relative w-full lg:max-w-xs">
            <i class="ph ph-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-lg"></i>
            <input type="text" wire:model.live="search" placeholder="Cari data {{ $tab }}..." 
                class="w-full bg-white border border-slate-200 rounded-2xl pl-12 pr-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl mb-6 text-sm font-medium flex items-center gap-2">
            <i class="ph-fill ph-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">IDENTITAS</th>
                        @if($tab === 'Produk')
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">INFO PRODUK</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">STOK</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">HARGA</th>
                        @else
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">ALAMAT / LOKASI</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">KONTAK / KODE</th>
                        @endif
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($items as $item)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-all duration-300">
                                    <i class="ph-fill {{ $tab === 'Produk' ? 'ph-package' : ($tab === 'Gudang' ? 'ph-warehouse' : 'ph-user') }} text-2xl"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $item->name }}</p>
                                    <p class="text-xs text-slate-400 font-medium">#{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        @if($tab === 'Produk')
                            <td class="px-8 py-5 text-sm font-medium text-slate-600">
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded-md text-[10px] font-bold uppercase mr-1">{{ $item->brand ?? '-' }}</span>
                                {{ $item->type ?? '-' }}
                            </td>
                            <td class="px-8 py-5">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $item->stock <= 5 ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                    {{ $item->stock }} {{ $item->unit }}
                                </span>
                            </td>
                            <td class="px-8 py-5 text-sm font-black text-slate-800">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        @else
                            <td class="px-8 py-5 text-sm text-slate-500 italic max-w-xs truncate">
                                {{ $item->address ?? $item->location ?? '-' }}
                            </td>
                            <td class="px-8 py-5 text-sm font-bold text-slate-700">
                                {{ $item->phone ?? $item->code ?? '-' }}
                            </td>
                        @endif
                        <td class="px-8 py-5">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="openModal({{ $item->id }})" class="p-2.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all"><i class="ph ph-pencil-simple text-xl"></i></button>
                                <button wire:click="delete({{ $item->id }})" wire:confirm="Yakin ingin menghapus data ini?" class="p-2.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-all"><i class="ph ph-trash text-xl"></i></button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-8 py-12 text-center text-slate-400 italic">Data {{ $tab }} tidak ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- CRUD Modal -->
    @if($showModal)
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
        <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-white">
                <div>
                    <h3 class="font-black text-slate-800 text-xl">{{ $editingId ? 'Edit' : 'Tambah' }} {{ $tab }}</h3>
                    <p class="text-xs text-slate-500 font-medium">Lengkapi informasi entitas di bawah ini</p>
                </div>
                <button wire:click="closeModal()" class="text-slate-400 hover:text-rose-500 p-2 rounded-xl hover:bg-rose-50 transition-all">
                    <i class="ph-bold ph-x text-xl"></i>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-8">
                <form wire:submit.prevent="save" class="space-y-5">
                    @if($tab === 'Produk')
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Produk</label>
                            <input type="text" wire:model="fields.name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('fields.name') <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Brand</label>
                                <input type="text" wire:model="fields.brand" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tipe</label>
                                <input type="text" wire:model="fields.type" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Satuan</label>
                                <input type="text" wire:model="fields.unit" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            </div>
                            <div class="col-span-2">
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Harga Jual</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-bold">Rp</span>
                                    <input type="number" wire:model="fields.price" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                                </div>
                            </div>
                        </div>
                        @if(!$editingId)
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Stok Awal</label>
                            <input type="number" wire:model="fields.stock" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                        @endif

                    @elseif($tab === 'Customer' || $tab === 'Supplier')
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama {{ $tab }}</label>
                            <input type="text" wire:model="fields.name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('fields.name') <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Telepon / WhatsApp</label>
                            <input type="text" wire:model="fields.phone" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Lengkap</label>
                            <textarea wire:model="fields.address" rows="3" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all resize-none"></textarea>
                        </div>

                    @elseif($tab === 'Gudang')
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Kode Gudang</label>
                            <input type="text" wire:model="fields.code" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all uppercase" placeholder="Contoh: GDG-01">
                            @error('fields.code') <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nama Gudang</label>
                            <input type="text" wire:model="fields.name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                            @error('fields.name') <span class="text-rose-500 text-[10px] font-bold mt-1">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Lokasi / Kota</label>
                            <input type="text" wire:model="fields.location" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm font-medium outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                        </div>
                    @endif

                    <div class="pt-4 flex gap-3">
                        <button type="button" wire:click="closeModal()" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold py-3 rounded-2xl transition-all">Batal</button>
                        <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-2xl shadow-lg shadow-indigo-200 transition-all active:scale-95">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
