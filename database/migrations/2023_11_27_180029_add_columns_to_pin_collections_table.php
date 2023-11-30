<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToPinCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pin_collections', function (Blueprint $table) {
            $table->integer('quantity');
            $table->boolean('delivered')->default(true);
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
            $table->dropColumn(['quantity', 'delivered']);
        });
    }
}
