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
        Schema::create('fee_payment_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_id');
            $table->unsignedBigInteger('fee_item_id');
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('amount', 20);
            $table->timestamps();
            
            $table->foreign('fee_item_id')->references('id')->on('fee_items')->onDelete('RESTRICT');
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('RESTRICT');
            $table->foreign('fee_id')->references('id')->on('fees')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_payment_items');
    }
};
