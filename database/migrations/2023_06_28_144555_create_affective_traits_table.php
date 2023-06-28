<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectiveTraitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affective_traits', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('school_id');
            $table->timestamps();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affective_traits');
    }
}
