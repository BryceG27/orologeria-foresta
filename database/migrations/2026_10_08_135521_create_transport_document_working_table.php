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
        Schema::create('transport_document_working', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\TransportDocument::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Working::class)->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_document_working');
    }
};
