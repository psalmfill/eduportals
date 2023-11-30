<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_id');
            $table->morphs('paymentable');
            $table->unsignedBigInteger('payment_gateway_id')->nullable();
            $table->string('reference')->unique();
            $table->float('amount');
            $table->string('amount_currency')->default('NGN');
            $table->enum('status', ['pending', 'cancelled', 'declined', 'failed', 'completed']);
            $table->json('meta_data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references(
                'id'
            )->on('users')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
