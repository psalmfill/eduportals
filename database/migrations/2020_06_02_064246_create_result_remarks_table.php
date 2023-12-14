<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResultRemarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_remarks', function (Blueprint $table) {
            $table->id();
            $table->string('headmaster');
            $table->string('teacher');
            $table->integer('max_average');
            $table->integer('min_average');
            $table->string('next_term_fee')->nullable();
            $table->date('next_term_begins')->nullable();
            $table->string('decision');
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('academic_session_id');
            $table->unsignedBigInteger('exam_id');
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
        Schema::dropIfExists('result_remarks');
    }
}
