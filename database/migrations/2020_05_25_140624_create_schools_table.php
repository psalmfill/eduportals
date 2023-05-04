<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('code');
            $table->string('address');
            $table->string('email');
            $table->string('phone_number');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('logo')->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('school_category_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('schools');
    }
}
