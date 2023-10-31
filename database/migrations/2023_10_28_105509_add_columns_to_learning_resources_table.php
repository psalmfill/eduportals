<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToLearningResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('learning_resources', function (Blueprint $table) {
            $table->text('description')->nullable()->after('title');
            $table->text('content_images')->nullable()->after('content');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('learning_resources', function (Blueprint $table) {
            $table->dropColumn(['description', 'content_images']);
        });
    }
}
