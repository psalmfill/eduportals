<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->boolean('active')->default(1);
            $table->timestamps();
        });

        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Super Admin',
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'name' => 'Vendor',
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'name' => 'School Admin',
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'name' => 'Parent',
                'created_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
