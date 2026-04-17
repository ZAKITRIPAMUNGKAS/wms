<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\DeliveryOrder;
use App\Models\GoodsReceipt;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return Inertia::render('Reports/Index', [
            'summary' => [
                'total_keluar_nilai' => DeliveryOrder::sum('total'),
                'total_keluar_qty' => DB::table('delivery_order_items')->sum('quantity'),
            ],
            'recentTransactions' => DB::table('delivery_order_items')
                ->join('delivery_orders', 'delivery_order_items.delivery_order_id', '=', 'delivery_orders.id')
                ->join('products', 'delivery_order_items.product_id', '=', 'products.id')
                ->join('customers', 'delivery_orders.customer_id', '=', 'customers.id')
                ->select(
                    'delivery_orders.tanggal',
                    'delivery_orders.no_sj',
                    'customers.nama as customer_name',
                    'products.nama as product_name',
                    'delivery_order_items.quantity',
                    'delivery_order_items.subtotal'
                )
                ->orderBy('delivery_orders.tanggal', 'desc')
                ->limit(50)
                ->get()
        ]);
    }

    public function exportExcel()
    {
        // Implementation for Excel export using Maatwebsite/Laravel-Excel
    }
}
