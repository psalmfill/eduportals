<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddExpenditureCategoryIdToExpendituresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('expenditures', function (Blueprint $table) {
            $table->unsignedBigInteger('expenditure_category_id')->nullable();
            $table->foreign('expenditure_category_id')->references('id')->on('expenditure_categories')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenditures', function (Blueprint $table) {
            $table->dropForeign(['expenditure_category_id']);
            $table->dropColumn('expenditure_category_id');
        });
    }
}
