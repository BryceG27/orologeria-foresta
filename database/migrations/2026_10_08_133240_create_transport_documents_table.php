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
        Schema::create('transport_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Workshop::class)->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('document_id');
            $table->date('date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport_documents');
    }
};
