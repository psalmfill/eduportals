<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiegnKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('pin_collections', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
        });
        Schema::table('transactions', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('CASCADE');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('CASCADE');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('SET NULL');
        });
        Schema::table('fees', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('CASCADE');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('CASCADE');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('SET NULL');
        });
        Schema::table('question_options', function (Blueprint $table) {
            $table->foreign('question_id')->references('id')->on('questions')->onDelete('CASCADE');
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('CASCADE');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
        });

        Schema::table('hostels', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
        });

        Schema::table('hostel_rooms', function (Blueprint $table) {
            $table->foreign('hostel_id')->references('id')->on('hostels')->onDelete('CASCADE');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
        });

        Schema::table('pins', function (Blueprint $table) {
            $table->foreign('pin_collection_id')->references('id')->on('pin_collections')->onDelete('CASCADE');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('CASCADE');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('CASCADE');
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
        Schema::table('pin_collections', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['academic_session_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['student_id']);
        });
        Schema::table('fees', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['academic_session_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['student_id']);
        });
        Schema::table('question_options', function (Blueprint $table) {
            $table->dropForeign(['question_id']);
        });
        Schema::table('questions', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['school_id']);
        });

        Schema::table('hostels', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('hostel_rooms', function (Blueprint $table) {
            $table->dropForeign(['hostel_id']);
            $table->dropForeign(['school_id']);
        });

        Schema::table('pins', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['pin_collection_id']);
            $table->dropForeign(['academic_session_id']);
            $table->dropForeign(['exam_id']);
        });
    }
}
