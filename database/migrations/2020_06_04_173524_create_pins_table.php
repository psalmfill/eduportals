<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pins', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['login'])->default('login');
            $table->string('ref_code')->unique();
            $table->string('serial_number')->unique();
            $table->date('activation_date')->nullable();
            $table->integer('duration'); //duration in days
            $table->date('expiry_date')->nullable();
            $table->boolean('downloaded')->default(0);
            $table->unsignedBigInteger('student_id')->nullable();
            $table->unsignedBigInteger('school_id');
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
        Schema::dropIfExists('pins');
    }
}
