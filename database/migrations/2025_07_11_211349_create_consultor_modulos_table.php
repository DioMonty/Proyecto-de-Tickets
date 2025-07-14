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
        Schema::create('consultor_modulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_consultor')->constrined('consultors');
            $table->foreignId('id_modulo')->constrained('modulos');
            $table->decimal('costo_funcional', 10, 2)->default(0.00);
            $table->decimal('costo_cliente', 10, 2)->default(0.00);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultor_modulos');
    }
};
