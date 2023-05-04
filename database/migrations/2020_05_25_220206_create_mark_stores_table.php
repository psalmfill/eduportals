<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarkStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mark_stores', function (Blueprint $table) {
            $table->id();
            $table->integer('score')->nullable();
            $table->boolean('absent')->default(0);
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('exam_type_id');
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('school_class_id');
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
        Schema::dropIfExists('mark_stores');
    }
}
