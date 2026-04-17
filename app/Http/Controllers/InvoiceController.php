<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        return Inertia::render('Invoices/Index', [
            'invoices' => Invoice::with(['deliveryOrder.customer', 'deliveryOrder.warehouse'])->latest()->paginate(10),
        ]);
    }

    public function show(Invoice $invoice)
    {
        return $invoice->load(['deliveryOrder.customer', 'deliveryOrder.warehouse', 'deliveryOrder.items.product', 'payments']);
    }

    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load(['deliveryOrder.customer', 'deliveryOrder.warehouse', 'deliveryOrder.items.product']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));
        
        return $pdf->download("invoice-{$invoice->no_invoice}.pdf");
    }
}
