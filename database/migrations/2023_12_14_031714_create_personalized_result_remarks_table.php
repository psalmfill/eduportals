<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalizedResultRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalized_result_remarks', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('school_id');
            $table->timestamps();

            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personalized_result_remarks');
    }
}
