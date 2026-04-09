<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;

class OutboundManager extends Component
{
    public $customer_id;
    public $notes;
    public $items = []; // [{product_id, qty, price, max_stock}]
    public $has_error = false;

    public function mount()
    {
        $this->addItem();
    }

    public function addItem($productId = null)
    {
        $product = $productId ? Product::find($productId) : null;
        
        $this->items[] = [
            'product_id' => $productId,
            'qty' => 1,
            'price' => $product ? $product->price * 1.25 : 0, // 25% margin
            'max_stock' => $product ? $product->stock : 0
        ];
        
        $this->validateStock();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->validateStock();
    }

    public function updatedItems($value, $key)
    {
        // If product_id changed, update price and max_stock
        if (str_ends_with($key, '.product_id')) {
            $index = explode('.', $key)[0];
            $product = Product::find($value);
            if ($product) {
                $this->items[$index]['price'] = $product->price * 1.25;
                $this->items[$index]['max_stock'] = $product->stock;
            }
        }
        $this->validateStock();
    }

    public function validateStock()
    {
        $this->has_error = false;
        foreach ($this->items as $item) {
            if ($item['product_id'] && $item['qty'] > $item['max_stock']) {
                $this->has_error = true;
                break;
            }
        }
    }

    public function simulateScan()
    {
        $product = Product::where('stock', '>', 0)->inRandomOrder()->first();
        if ($product) {
            $this->addItem($product->id);
            session()->flash('scan_message', 'Barcode Terdeteksi: ' . $product->name);
        }
    }

    public function save()
    {
        if (!$this->customer_id) return session()->flash('error', 'Pilih Customer!');
        if (empty($this->items)) return session()->flash('error', 'Item kosong!');
        if ($this->has_error) return session()->flash('error', 'Ada item yang melebihi stok!');

        DB::transaction(function () {
            $customer = Customer::find($this->customer_id);
            
            $transaction = Transaction::create([
                'type' => 'Keluar',
                'mitra_name' => $customer->name,
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
                Product::where('id', $item['product_id'])->decrement('stock', $item['qty']);
            }
        });

        return redirect()->route('transaction.show', ['id' => $transaction->id])->with('message', 'Barang Keluar Berhasil Diproses!');
    }

    public function render()
    {
        return view('livewire.outbound-manager', [
            'customers' => Customer::all(),
            'products' => Product::all(),
            'total' => collect($this->items)->sum(fn($i) => $i['qty'] * (is_numeric($i['price']) ? $i['price'] : 0))
        ]);
    }
}
