<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLearningResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('learning_resources', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('title');
            $table->string('type')->default('text');
            $table->text('content')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('learning_resources');
    }
}
