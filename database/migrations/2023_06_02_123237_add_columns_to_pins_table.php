<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pins', function (Blueprint $table) {
            $table->unsignedBigInteger('school_class_id')->nullable();
            $table->unsignedBigInteger('section_id')->nullable();
            $table->string('result_type')->nullable();
            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('SET NULL');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pins', function (Blueprint $table) {
            $table->dropForeign(['school_class_id']);
            $table->dropForeign(['section_id']);
            $table->dropColumn('school_class_id');
            $table->dropColumn('section_id');
            $table->dropColumn('result_type');
        });
    }
}
