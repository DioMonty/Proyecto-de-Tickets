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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->char('nombre_ticket', length: 255);
            $table->enum('tipo_ticket', ['OC','Bolsa']);
            $table->char('oc_bolsa', length: 100)->nullable();
            
            $table->foreignId('id_modulo')->constrained('modulos');
            $table->foreignId('id_estado')->constrained('estados');
            $table->foreignId('id_cliente')->constrained('users')->nullable();
            $table->foreignId('id_sociedad')->constrained('user_societies')->nullable();
            $table->char('solicitante', length: 200)->nullable();

            $table->foreignId('id_abap')->constrained('consultors')->nullable();
            $table->char('hora_abap', length: 5)->nullable();
            $table->decimal('costo_abap', 10, 2)->default(0.00);

            $table->foreignId('id_funcional')->constrained('consultors')->nullable();
            $table->char('hora_funcional', length: 5)->nullable();
            $table->decimal('costo_funcional', 10, 2)->default(0.00);

            $table->decimal('costo_total', 10, 2)->default(0.00);
            $table->char('total_horas', length: 5)->nullable();

            $table->datetime('fecha_prd')->nullable();
            $table->datetime('fecha_inicio')->nullable();
            $table->datetime('fecha_resolucion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
