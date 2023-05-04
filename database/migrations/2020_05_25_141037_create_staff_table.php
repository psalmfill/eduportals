<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('gender',['male','female'])->default('male');
            $table->date('date_of_birth');
            $table->string('email');
            $table->string('image')->nullable();
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('religion')->nullable();
            $table->string('country')->default('Nigeria');
            $table->string('state');
            $table->string('city');
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('staff');
    }
}
