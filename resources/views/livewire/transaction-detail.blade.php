<div>
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-8 no-print">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Detail Transaksi</h2>
            <p class="text-sm text-slate-500 font-medium">No. Transaksi: #{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ $transaction->type === 'Masuk' ? route('barang-masuk.index') : route('barang-keluar.index') }}" class="px-6 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold flex items-center gap-2 hover:bg-slate-50 transition-all">
                <i class="ph ph-arrow-left"></i> Kembali
            </a>
            <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-2xl font-bold flex items-center gap-2 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                <i class="ph-bold ph-printer text-lg"></i>
                Cetak Dokumen
            </button>
        </div>
    </div>

    <!-- Document Card -->
    <div class="bg-white border border-slate-200 rounded-[2.5rem] shadow-sm p-10 md:p-16 max-w-4xl mx-auto print:shadow-none print:border-none print:p-0 print:m-0">
        
        <!-- Header -->
        <div class="flex justify-between items-start border-b-2 border-slate-900 pb-8 mb-10">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-indigo-600 rounded-2xl">
                    <i class="ph-fill ph-package text-white text-3xl"></i>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight uppercase">Nama Perusahaan</h1>
                    <p class="text-[10px] text-slate-500 font-bold tracking-widest uppercase">Warehouse & Logistics Solutions</p>
                </div>
            </div>
            <div class="text-right">
                <h2 class="text-4xl font-black text-indigo-600 tracking-tighter uppercase mb-1">{{ $transaction->type === 'Masuk' ? 'BUKTI MASUK' : 'SURAT JALAN' }}</h2>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-[0.3em] italic">{{ $transaction->type === 'Masuk' ? 'Good Receipt' : 'Delivery Order' }}</p>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-12 mb-12">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 pb-1 w-fit">{{ $transaction->type === 'Masuk' ? 'Diterima Dari:' : 'Tujuan Pengiriman:' }}</p>
                <h3 class="text-xl font-black text-slate-900">{{ $transaction->mitra_name }}</h3>
                <p class="text-sm text-slate-500 mt-2 leading-relaxed italic">Catatan: {{ $transaction->notes ?? '-' }}</p>
            </div>
            <div class="bg-slate-50 p-8 rounded-[2rem] border border-slate-200/50">
                <table class="w-full text-xs">
                    <tr class="border-b border-slate-200/60">
                        <td class="py-2.5 font-bold text-slate-400 uppercase tracking-widest">No. Dokumen</td>
                        <td class="py-2.5 text-right font-black text-slate-900"># {{ $transaction->type === 'Masuk' ? 'BM' : 'SJ' }}-{{ date('Y', strtotime($transaction->date)) }}-{{ str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr class="border-b border-slate-200/60">
                        <td class="py-2.5 font-bold text-slate-400 uppercase tracking-widest">Tanggal</td>
                        <td class="py-2.5 text-right font-black text-slate-900">{{ date('d F Y', strtotime($transaction->date)) }}</td>
                    </tr>
                    <tr>
                        <td class="py-2.5 font-bold text-slate-400 uppercase tracking-widest">Status</td>
                        <td class="py-2.5 text-right font-black text-emerald-600">Terverifikasi System</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-12">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900 text-white border-none">
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-[0.2em] rounded-l-2xl w-16 text-center">NO</th>
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-[0.2em]">DESKRIPSI BARANG</th>
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-[0.2em] text-center w-24">QTY</th>
                        <th class="py-4 px-6 text-[10px] font-black uppercase tracking-[0.2em] text-right rounded-r-2xl">SUBTOTAL (Rp)</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-slate-700 divide-y divide-slate-100 border-b-2 border-slate-900">
                    @foreach($transaction->items as $index => $item)
                    <tr>
                        <td class="py-6 px-6 text-center font-bold text-slate-400">{{ $index + 1 }}</td>
                        <td class="py-6 px-6">
                            <div class="font-black text-slate-900">{{ $item->product->name }}</div>
                            <div class="text-[10px] text-slate-400 font-bold uppercase mt-1 tracking-wider">{{ $item->product->brand }} - {{ $item->product->type }}</div>
                        </td>
                        <td class="py-6 px-6 text-center font-black text-slate-900">{{ $item->qty }} <span class="text-[10px] text-slate-400 ml-0.5">{{ $item->product->unit }}</span></td>
                        <td class="py-6 px-6 text-right font-black text-slate-900">{{ number_format($item->qty * $item->price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="flex justify-end mb-16">
            <div class="w-full max-w-xs bg-slate-900 text-white rounded-3xl p-6 shadow-xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-500/10 rounded-full -mr-16 -mt-16"></div>
                <div class="relative">
                    <p class="text-[10px] font-black text-indigo-300 uppercase tracking-[0.2em] mb-1 text-center">TOTAL NILAI BARANG</p>
                    <h4 class="text-2xl font-black text-center">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h4>
                </div>
            </div>
        </div>

        <!-- Signatures -->
        <div class="grid grid-cols-3 gap-8 pt-12 border-t border-slate-100">
            <div class="text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-16">{{ $transaction->type === 'Masuk' ? 'Diterima Oleh,' : 'Penerima,' }}</p>
                <div class="w-full h-0.5 bg-slate-200 mx-auto"></div>
                <p class="text-[10px] font-black text-slate-900 mt-3 uppercase tracking-wider">( ..................................... )</p>
            </div>
            <div class="text-center italic">
                <p class="text-[9px] text-slate-300 font-medium leading-relaxed mt-20">Dokumen sah diterbitkan otomatis melalui system logistik terpusat.</p>
            </div>
            <div class="text-center">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-16">Hormat Kami,</p>
                <div class="w-full h-0.5 bg-slate-900 mx-auto"></div>
                <p class="text-[11px] font-black text-slate-900 mt-3 uppercase tracking-widest">GUDANG OPERASIONAL</p>
            </div>
        </div>

        <footer class="mt-20 text-center text-[9px] text-slate-300 font-bold uppercase tracking-[0.3em] italic border-t border-slate-50 pt-6">
            BUKTI SERAH TERIMA BARANG – NAMA PERUSAHAAN LOGISTICS
        </footer>

    </div>

    <!-- Print Styles -->
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
            .print\:shadow-none {
                box-shadow: none !important;
            }
            .print\:border-none {
                border: none !important;
            }
        }
    </style>
</div>
