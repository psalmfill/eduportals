<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('slogan')->nullable();
            $table->string('favicon')->nullable();
            $table->string('date_format')->default('d-m-Y');
            $table->string('school_stamp')->nullable();
            $table->string('coat_of_arm')->nullable();
            $table->string('tagline')->nullable();
            $table->string('currency_symbol')->default('N');
            $table->unsignedBigInteger('current_session_id')->nullable();
            $table->unsignedBigInteger('current_term_id')->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}
