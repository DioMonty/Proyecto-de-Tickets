<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE users CHANGE lastname apellido VARCHAR(255) NOT NULL");
    }

    public function down()
    {
        DB::statement("ALTER TABLE users CHANGE apellido lastname VARCHAR(255) NOT NULL");
    }
};
