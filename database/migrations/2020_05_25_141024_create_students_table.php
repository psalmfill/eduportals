<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('other_name')->nullable();
            $table->enum('gender',['male','female'])->default('male');
            $table->date('date_of_birth');
            $table->string('email')->nullable();
            $table->string('reg_no');
            $table->string('image')->nullable();
            $table->string('religion')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('blood_group')->nullable();
            $table->string('genotype')->nullable();
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->boolean('active')->default(1);
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
        Schema::dropIfExists('students');
    }
}
