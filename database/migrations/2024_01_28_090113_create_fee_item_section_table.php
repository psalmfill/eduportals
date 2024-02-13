<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fee_item_section', function (Blueprint $table) {
            $table->unsignedBigInteger('fee_item_id');
            $table->unsignedBigInteger('school_class_id');
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('school_id');
            $table->timestamps();

            $table->foreign('school_class_id')->references('id')->on('school_classes')->onDelete('CASCADE');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('CASCADE');
            $table->foreign('fee_item_id')->references('id')->on('fee_items')->onDelete('CASCADE');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_item_section');
    }
};
