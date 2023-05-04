<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePsychomotorGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('psychomotor_grades', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('remark');
            $table->unsignedBigInteger('psychomotor_id');
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
        Schema::dropIfExists('psychomotor_grades');
    }
}
