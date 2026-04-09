<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;

class HistoryManager extends Component
{
    use WithPagination;

    public $search = '';
    public $type = 'all'; // all, Masuk, Keluar
    public $date_from;
    public $date_to;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Transaction::query();

        if ($this->search) {
            $query->where('mitra_name', 'like', '%' . $this->search . '%')
                  ->orWhere('id', 'like', '%' . $this->search . '%');
        }

        if ($this->type !== 'all') {
            $query->where('type', $this->type);
        }

        if ($this->date_from) {
            $query->whereDate('date', '>=', $this->date_from);
        }

        if ($this->date_to) {
            $query->whereDate('date', '<=', $this->date_to);
        }

        return view('livewire.history-manager', [
            'transactions' => $query->latest()->paginate(10)
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'type', 'date_from', 'date_to']);
        $this->resetPage();
    }
}
