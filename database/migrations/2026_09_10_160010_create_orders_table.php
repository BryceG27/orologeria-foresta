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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Customer::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\OrderStatus::class)->default(1)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\PaymentOrderStatus::class)->default(1)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Brand::class)->nullable()->constrained();
            $table->text('description');
            $table->date('order_date');
            $table->decimal('downpayment', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
