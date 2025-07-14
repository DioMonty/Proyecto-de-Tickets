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
        Schema::create('sociedads', function (Blueprint $table) {
            $table->id();
            $table->char('nombre_sociedad', length: 100);
            $table->char('razon_social', length: 100);
            $table->char('ruc', length: 20);
            $table->char('direccion', length: 100);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sociedads');

    }
};
