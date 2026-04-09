<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
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
    }
}
