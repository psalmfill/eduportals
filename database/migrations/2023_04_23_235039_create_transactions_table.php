<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('term_id');
            $table->morphs('staffable');
            $table->unsignedBigInteger('student_id')->nullable();
            $table->string('reference')->unique();
            $table->enum('type', ['credit', 'debit']);
            $table->string('channel')->default('fee');
            $table->morphs('transactable');
            $table->decimal('amount');
            $table->enum('status', ['pending', 'confirmed', 'cancelled', 'declined'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
