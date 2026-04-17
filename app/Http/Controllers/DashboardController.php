<?php

namespace App\Http\Controllers;

use App\Models\Product;
<<<<<<< HEAD
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
=======
use App\Models\GoodsReceipt;
use App\Models\DeliveryOrder;
use App\Models\Invoice;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
>>>>>>> 5dcac91 (Refactor: Mobile-first responsive UI and performance optimization)

class DashboardController extends Controller
{
    public function index()
    {
<<<<<<< HEAD
        $today = Carbon::today();

        $stats = [
            'total_stock' => Product::sum('stock'),
            'in_today' => Transaction::where('type', 'Masuk')->whereDate('date', $today)->count(),
            'out_today' => Transaction::where('type', 'Keluar')->whereDate('date', $today)->count(),
            'total_value' => Product::get()->sum(fn($p) => $p->stock * $p->price),
            'low_stock_count' => Product::whereBetween('stock', [1, 5])->count(),
            'total_products' => Product::count(),
        ];

        $recentTransactions = Transaction::with('items')
            ->orderBy('date', 'desc')
            ->orderBy('id', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact('stats', 'recentTransactions'));
=======
        return Inertia::render('Dashboard', [
            'stats' => [
                'total_products' => Product::count(),
                'total_stock' => ProductStock::sum('quantity'),
                'today_receipts' => GoodsReceipt::whereDate('tanggal', today())->count(),
                'today_orders' => DeliveryOrder::whereDate('tanggal', today())->count(),
                'pending_invoices_amount' => Invoice::where('status', '!=', 'lunas')->sum('total'),
            ],
            'recentTransactions' => DB::table('stock_movements')
                ->join('products', 'stock_movements.product_id', '=', 'products.id')
                ->select('stock_movements.*', 'products.nama as product_name')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
        ]);
>>>>>>> 5dcac91 (Refactor: Mobile-first responsive UI and performance optimization)
    }
}
