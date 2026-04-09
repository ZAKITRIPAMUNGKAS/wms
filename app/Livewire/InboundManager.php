<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class InboundManager extends Component
{
    public $supplier_id;
    public $notes;
    public $items = []; // [{product_id, qty, price}]

    public function mount()
    {
        $this->addItem();
    }

    public function addItem($productId = null)
    {
        $this->items[] = [
            'product_id' => $productId,
            'qty' => 1,
            'price' => $productId ? Product::find($productId)->price : 0
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function simulateScan()
    {
        $product = Product::inRandomOrder()->first();
        if ($product) {
            $this->addItem($product->id);
            session()->flash('scan_message', 'Barcode Terdeteksi: ' . $product->name);
        }
    }

    public function save()
    {
        if (!$this->supplier_id) return session()->flash('error', 'Pilih Supplier!');
        if (empty($this->items)) return session()->flash('error', 'Item kosong!');

        DB::transaction(function () {
            $supplier = Supplier::find($this->supplier_id);
            
            $transaction = Transaction::create([
                'type' => 'Masuk',
                'mitra_name' => $supplier->name,
                'date' => now(),
                'total_amount' => collect($this->items)->sum(fn($i) => $i['qty'] * $i['price']),
                'notes' => $this->notes
            ]);

            foreach ($this->items as $item) {
                if (!$item['product_id']) continue;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'qty' => $item['qty'],
                    'price' => $item['price']
                ]);

                // Update Stock
                Product::where('id', $item['product_id'])->increment('stock', $item['qty']);
            }
        });

        return redirect()->route('transaction.show', ['id' => $transaction->id])->with('message', 'Barang Masuk Berhasil Diproses!');
    }

    public function render()
    {
        return view('livewire.inbound-manager', [
            'suppliers' => Supplier::all(),
            'products' => Product::all(),
            'total' => collect($this->items)->sum(fn($i) => $i['qty'] * (is_numeric($i['price']) ? $i['price'] : 0))
        ]);
    }
}
