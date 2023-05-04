<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_schedules', function (Blueprint $table) {
            $table->id();
            $table->time('start_time');
            $table->time('end_time');
            $table->date('date');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('exam_type_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('section_id');
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
        Schema::dropIfExists('exam_schedules');
    }
}
