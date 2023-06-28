<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectiveTraitSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affective_trait_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('affective_trait_id');
            $table->unsignedBigInteger('school_id');
            $table->timestamps();
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
            $table->foreign('affective_trait_id')->references('id')->on('affective_traits')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('affective_trait_subjects');
    }
}
