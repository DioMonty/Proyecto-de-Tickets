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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ticket_estado')->constrained('estado_fecha_tickets');

            $table->string('nombre_original')->nullable();
            $table->string('extension')->nullable(); // 'pdf', 'jpg', etc.
            $table->text('ruta_documento')->nullable();
            $table->unsignedBigInteger('tamano_bytes')->nullable();

            $table->foreignId('subido_por')->constrained('users');
            $table->datetime('fecha_subida')->nullable();
            $table->boolean('estado')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentos');
    }
};
