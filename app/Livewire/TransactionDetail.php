<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Transaction;

class TransactionDetail extends Component
{
    public $transactionId;

    public function mount($id)
    {
        $this->transactionId = $id;
    }

    public function render()
    {
        $transaction = Transaction::with(['items.product'])->findOrFail($this->transactionId);
        
        return view('livewire.transaction-detail', [
            'transaction' => $transaction
        ]);
    }
}
