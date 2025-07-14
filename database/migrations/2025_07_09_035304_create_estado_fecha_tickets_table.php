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
        Schema::create('estado_fecha_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ticket')->constrained('tickets');
            $table->foreignId('id_estado')->constrained('estados');
            $table->datetime('fecha_estado')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estado_fecha_tickets');
    }
};
