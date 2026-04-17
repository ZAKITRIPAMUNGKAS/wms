<?php

namespace App\Http\Controllers;

use App\Models\GoodsReceipt;
use App\Models\GoodsReceiptItem;
use App\Models\PurchaseOrder;
use App\Models\Warehouse;
use App\Models\Product;
use App\Services\StockService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GoodsReceiptController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function index()
    {
        return Inertia::render('BarangMasuk/Index', [
            'receipts' => GoodsReceipt::with(['purchaseOrder', 'warehouse', 'user'])->latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return Inertia::render('BarangMasuk/Create', [
            'purchaseOrders' => PurchaseOrder::where('status', '!=', 'received')->get(),
            'warehouses' => Warehouse::all(),
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($validated) {
            $receipt = GoodsReceipt::create([
                'no_receipt' => $this->generateNoReceipt(),
                'purchase_order_id' => $validated['purchase_order_id'],
                'warehouse_id' => $validated['warehouse_id'],
                'tanggal' => $validated['tanggal'],
                'catatan' => $validated['catatan'],
                'user_id' => Auth::id(),
            ]);

            foreach ($validated['items'] as $item) {
                GoodsReceiptItem::create([
                    'goods_receipt_id' => $receipt->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                ]);

                $this->stockService->adjustStock(
                    $item['product_id'],
                    $receipt->warehouse_id,
                    $item['quantity'],
                    'in',
                    'goods_receipt',
                    $receipt->id,
                    Auth::id()
                );
            }

            // Update PO status
            $po = PurchaseOrder::find($validated['purchase_order_id']);
            $po->status = 'received';
            $po->save();
        });

        return redirect()->back();
    }

    protected function generateNoReceipt()
    {
        $date = date('Ymd');
        $count = GoodsReceipt::whereDate('created_at', today())->count() + 1;
        return "RCP-{$date}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
