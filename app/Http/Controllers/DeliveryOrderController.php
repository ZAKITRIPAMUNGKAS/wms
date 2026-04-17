<?php

namespace App\Http\Controllers;

use App\Models\DeliveryOrder;
use App\Models\Customer;
use App\Models\Warehouse;
use App\Models\Product;
use App\Services\DeliveryOrderService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DeliveryOrderController extends Controller
{
    protected $doService;

    public function __construct(DeliveryOrderService $doService)
    {
        $this->doService = $doService;
    }

    public function index()
    {
        return Inertia::render('BarangKeluar/Index', [
            'deliveryOrders' => DeliveryOrder::with(['customer', 'warehouse', 'user'])->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('BarangKeluar/Create', [
            'customers' => Customer::all(),
            'warehouses' => Warehouse::all(),
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'tanggal' => 'required|date',
            'payment_term' => 'required|string',
            'total' => 'required|numeric',
            'due_date' => 'nullable|date',
            'keterangan' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.harga' => 'required|numeric',
            'items.*.subtotal' => 'required|numeric',
        ]);

        try {
            $this->doService->createDeliveryOrder($validated);
            return redirect()->back();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
