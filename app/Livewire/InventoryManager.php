<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use Livewire\WithPagination;

class InventoryManager extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all'; // all, low_stock, out_of_stock

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%');
        }

        if ($this->filter === 'low_stock') {
            $query->whereBetween('stock', [1, 5]);
        } elseif ($this->filter === 'out_of_stock') {
            $query->where('stock', '<=', 0);
        }

        return view('livewire.inventory-manager', [
            'products' => $query->latest()->paginate(10)
        ]);
    }
}
