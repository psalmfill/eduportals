<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dateTime('available_date')->nullable();
            $table->dateTime('submission_date')->nullable();
            $table->text('content_images')->nullable()->after('content');
            $table->text('resources_images')->nullable()->after('resources');
            $table->unsignedBigInteger('subject_id')->nullable()->after('term_id');
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
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropColumn(['available_date', 'submission_date', 'resources_images', 'subject_id']);
        });
    }
}
