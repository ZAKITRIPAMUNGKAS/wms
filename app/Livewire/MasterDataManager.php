<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Warehouse;

class MasterDataManager extends Component
{
    public $tab = 'Produk';
    public $search = '';
    public $showModal = false;
    
    // Form fields
    public $editingId = null;
    public $fields = [];

    protected $listeners = ['closeModal' => 'closeModal'];

    public function setTab($tab)
    {
        $this->tab = $tab;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->fields = [];
        $this->showModal = false;
        $this->resetValidation();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $this->editingId = $id;
            $model = $this->getModel();
            $data = $model::find($id);
            $this->fields = $data->toArray();
        } else {
            // Default values for new records
            if ($this->tab === 'Produk') {
                $this->fields = ['unit' => 'Pcs', 'price' => 0, 'stock' => 0];
            }
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    protected function getModel()
    {
        return match($this->tab) {
            'Produk' => Product::class,
            'Customer' => Customer::class,
            'Supplier' => Supplier::class,
            'Gudang' => Warehouse::class,
        };
    }

    public function save()
    {
        $rules = $this->getRules();
        $this->validate($rules);

        $model = $this->getModel();
        
        if ($this->editingId) {
            $model::find($this->editingId)->update($this->fields);
            session()->flash('message', 'Data berhasil diperbarui.');
        } else {
            $model::create($this->fields);
            session()->flash('message', 'Data berhasil ditambahkan.');
        }

        $this->resetForm();
    }

    protected function getRules()
    {
        return match($this->tab) {
            'Produk' => [
                'fields.name' => 'required|string|max:255',
                'fields.brand' => 'nullable|string|max:255',
                'fields.type' => 'nullable|string|max:255',
                'fields.unit' => 'required|string|max:50',
                'fields.price' => 'required|numeric|min:0',
                'fields.stock' => 'required|integer|min:0',
            ],
            'Customer', 'Supplier' => [
                'fields.name' => 'required|string|max:255',
                'fields.address' => 'nullable|string',
                'fields.phone' => 'nullable|string|max:20',
            ],
            'Gudang' => [
                'fields.code' => 'required|string|unique:warehouses,code,' . $this->editingId,
                'fields.name' => 'required|string|max:255',
                'fields.location' => 'nullable|string|max:255',
            ],
        };
    }

    public function render()
    {
        $model = $this->getModel();
        $query = $model::query();

        if ($this->search) {
            $query->where('name', 'like', '%' . $this->search . '%');
            if ($this->tab === 'Gudang') {
                $query->orWhere('code', 'like', '%' . $this->search . '%');
            }
        }

        return view('livewire.master-data-manager', [
            'items' => $query->latest()->get()
        ]);
    }

    public function delete($id)
    {
        $model = $this->getModel();
        $model::find($id)->delete();
        session()->flash('message', 'Data berhasil dihapus.');
    }
}
