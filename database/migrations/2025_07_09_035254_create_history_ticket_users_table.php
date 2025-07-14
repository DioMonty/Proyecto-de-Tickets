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
        Schema::create('history_ticket_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_ticket')->constrained('tickets');
            $table->foreignId('id_consultor')->constrained('consultors');
            $table->foreignId('id_rol')->constrained('rol_consultors');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_ticket_users');
    }
};
