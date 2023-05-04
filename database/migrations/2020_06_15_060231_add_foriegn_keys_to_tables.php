<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForiegnKeysToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('RESTRICT');
        });

        Schema::table('schools', function (Blueprint $table) {
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('RESTRICT');
            $table->foreign('school_category_id')->references('id')->on('school_categories')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->foreign('vendor_category_id')->references('id')->on('vendor_categories')->onDelete('RESTRICT');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('RESTRICT');
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });
        Schema::table('roles', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('grades', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('students', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('parent_id')->references('id')->on('users')->onDelete('RESTRICT');
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('school_classes', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('qualifications', function (Blueprint $table) {
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('RESTRICT');
        });

        Schema::table('mark_stores', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('RESTRICT');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('RESTRICT');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });

        Schema::table('school_class_section', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
        });

        Schema::table('exam_types', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
        });

        Schema::table('exams', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('RESTRICT');
        });

        Schema::table('school_class_staff', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
        });
        Schema::table('subject_staff', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
        });

        Schema::table('school_class_section_subject', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
        });

        Schema::table('psychomotors', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });
        Schema::table('psychomotor_subjects', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('psychomotor_id')->references('id')->on('psychomotors')->onDelete('RESTRICT');
        });

        Schema::table('psychomotor_grades', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('psychomotor_id')->references('id')->on('psychomotors')->onDelete('RESTRICT');
        });
        
        Schema::table('psychomotor_results', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('RESTRICT');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });

        Schema::table('result_remarks', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });

        Schema::table('general_settings', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('current_term_id')->references('id')->on('terms')->onDelete('RESTRICT');
            $table->foreign('current_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });

        Schema::table('school_staff', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('staff_id')->references('id')->on('staff')->onDelete('RESTRICT');
        });

        Schema::table('comment_result_groups', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('comment_result_items', function (Blueprint $table) {
            $table->foreign('comment_result_group_id')->references('id')->on('comment_result_groups')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('comment_result_grades', function (Blueprint $table) {
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
        });

        Schema::table('comment_results', function (Blueprint $table) {
            $table->foreign('comment_result_grade_id')->references('id')->on('comment_result_grades')->onDelete('RESTRICT');
            $table->foreign('comment_result_group_id')->references('id')->on('comment_result_groups')->onDelete('RESTRICT');
            $table->foreign('comment_result_item_id')->references('id')->on('comment_result_items')->onDelete('RESTRICT');
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('RESTRICT');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });
        Schema::table('exam_schedules', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('exam_id')->references('id')->on('exams')->onDelete('RESTRICT');
            $table->foreign('exam_type_id')->references('id')->on('exam_types')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('academic_session_id')->references('id')->on('academic_sessions')->onDelete('RESTRICT');
        });

        Schema::table('attendances', function (Blueprint $table) {
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('RESTRICT');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('RESTRICT');
            $table->foreign('term_id')->references('id')->on('terms')->onDelete('RESTRICT');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('RESTRICT');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('RESTRICT');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
        });
        Schema::table('schools', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['school_category_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['vendor_category_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::table('terms', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
        Schema::table('grades', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['parent_id']);
        });

        Schema::table('sections', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });
        

        Schema::table('school_classes', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('qualifications', function (Blueprint $table) {
            $table->dropForeign(['staff_id']);
        });

        Schema::table('mark_stores', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['exam_type_id']);
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['academic_session_id']);
        });

        Schema::table('school_class_section', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
        });

        Schema::table('exam_types', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['exam_id']);
        });
        
        Schema::table('exams', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['term_id']);
        });

        Schema::table('school_staff', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['staff_id']);
        });
        
        Schema::table('school_class_staff', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['school_id']);
            $table->dropForeign(['staff_id']);
            $table->dropForeign(['section_id']);
        });


        Schema::table('subject_staff', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['school_id']);
            $table->dropForeign(['staff_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['school_class_id']);
        });

        Schema::table('school_class_section_subject', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['school_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['school_class_id']);
        });
        

        Schema::table('psychomotors', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });


        Schema::table('psychomotor_subjects', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['psychomotor_id']);
        });


        Schema::table('psychomotor_grades', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['psychomotor_id']);
        });

        Schema::table('psychomotor_results', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['academic_session_id']);
        });


        Schema::table('result_remarks', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['academic_session_id']);
        });


        Schema::table('general_settings', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['current_term_id']);
            $table->dropForeign(['current_session_id']);
        });

        Schema::table('comment_result_groups', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });

        Schema::table('comment_result_items', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['comment_result_group_id']);
        });

        Schema::table('comment_result_grades', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
        });


        Schema::table('comment_results', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['comment_result_group_id']);
            $table->dropForeign(['comment_result_grade_id']);
            $table->dropForeign(['comment_result_item_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['academic_session_id']);
        });
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['term_id']);
            $table->dropForeign(['student_id']);
            $table->dropForeign(['academic_session_id']);
        });


        Schema::table('exam_schedules', function (Blueprint $table) {
            $table->dropForeign(['school_id']);
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropForeign(['exam_id']);
            $table->dropForeign(['exam_type_id']);
            $table->dropForeign(['academic_session_id']);
        });
        
    }

}
