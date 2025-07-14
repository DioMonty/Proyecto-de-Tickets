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
        Schema::create('history_ticket_costos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ticket')->constrained('tickets');
            $table->enum('rol', ['funcional','abap']);
            $table->enum('condicion', ['normal','adicional'])->default('normal');
            $table->char('horas', length: 5);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_ticket_costos');
    }
};
