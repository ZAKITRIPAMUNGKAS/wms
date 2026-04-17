<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
=======
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
>>>>>>> 5dcac91 (Refactor: Mobile-first responsive UI and performance optimization)
    use HasFactory;

    protected $guarded = [];

<<<<<<< HEAD
    public function items()
    {
        return $this->hasMany(TransactionItem::class);
=======
    public function stocks(): HasMany
    {
        return $this->hasMany(ProductStock::class);
    }

    public function purchaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function goodsReceiptItems(): HasMany
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }

    public function deliveryOrderItems(): HasMany
    {
        return $this->hasMany(DeliveryOrderItem::class);
    }

    public function stockMovements(): HasMany
    {
        return $this->hasMany(StockMovement::class);
>>>>>>> 5dcac91 (Refactor: Mobile-first responsive UI and performance optimization)
    }
}
