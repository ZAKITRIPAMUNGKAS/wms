<?php

namespace App\Services;

use App\Models\DeliveryOrder;
use App\Models\DeliveryOrderItem;
use App\Models\Invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DeliveryOrderService
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
    }

    public function createDeliveryOrder(array $data)
    {
        return DB::transaction(function () use ($data) {
            // 1. Create DO
            $do = DeliveryOrder::create([
                'no_sj' => $this->generateNoSj(),
                'customer_id' => $data['customer_id'],
                'warehouse_id' => $data['warehouse_id'],
                'tanggal' => $data['tanggal'],
                'payment_term' => $data['payment_term'],
                'total' => $data['total'],
                'status' => 'sent',
                'keterangan' => $data['keterangan'] ?? null,
                'user_id' => Auth::id()
            ]);

            // 2. Add Items and Deduct Stock
            foreach ($data['items'] as $item) {
                DeliveryOrderItem::create([
                    'delivery_order_id' => $do->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'harga' => $item['harga'],
                    'subtotal' => $item['subtotal']
                ]);

                $this->stockService->adjustStock(
                    $item['product_id'],
                    $do->warehouse_id,
                    $item['quantity'],
                    'out',
                    'delivery_order',
                    $do->id,
                    Auth::id()
                );
            }

            // 3. Auto-generate Invoice
            Invoice::create([
                'no_invoice' => str_replace('SJ', 'INV', $do->no_sj),
                'delivery_order_id' => $do->id,
                'tanggal' => $do->tanggal,
                'total' => $do->total,
                'paid_amount' => 0,
                'status' => 'belum_lunas',
                'payment_term' => $do->payment_term,
                'due_date' => $data['due_date'] ?? null
            ]);

            return $do;
        });
    }

    protected function generateNoSj()
    {
        $date = date('Ymd');
        $count = DeliveryOrder::whereDate('created_at', today())->count() + 1;
        return "SJ-{$date}-" . str_pad($count, 3, '0', STR_PAD_LEFT);
    }
}
