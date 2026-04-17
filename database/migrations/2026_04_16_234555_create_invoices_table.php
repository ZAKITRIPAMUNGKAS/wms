<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('no_invoice')->unique();
            $table->foreignId('delivery_order_id')->unique()->constrained()->onDelete('cascade');
            $table->date('tanggal');
            $table->decimal('total', 15, 2);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->enum('status', ['belum_lunas', 'partial', 'lunas'])->default('belum_lunas');
            $table->enum('payment_term', ['cash', 'tempo'])->default('cash');
            $table->date('due_date')->nullable();
            $table->timestamps();
            
            $table->index('no_invoice');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
