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
        Schema::create('workings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Customer::class)->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained('customers')->onDelete('cascade');
            $table->string('working_id');
            $table->foreignIdFor(\App\Models\WorkingStatus::class)->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Brand::class)->constrained()->onDelete('cascade');
            $table->string('reference')->nullable();
            $table->date('acceptance_date')->default(now());
            $table->date('delivery_date')->nullable();
            $table->text('working_description')->nullable();
            $table->text('extra_notes')->nullable();
            $table->foreignIdFor(\App\Models\PaymentMethod::class)->nullable()->constrained()->onDelete('cascade');
            $table->double('total_cost')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workings');
    }
};
