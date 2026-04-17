<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function index()
    {
        return Inertia::render('Payments/Index', [
            'invoices' => Invoice::with(['deliveryOrder.customer'])->latest()->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'nominal' => 'required|numeric|min:1',
            'tanggal' => 'required|date',
            'metode' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);

        $this->paymentService->recordPayment($validated);

        return redirect()->back();
    }
}
