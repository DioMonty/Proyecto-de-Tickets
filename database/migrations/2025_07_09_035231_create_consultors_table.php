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
        Schema::create('consultors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_usuario')->constrained(
                        table: 'users', indexName: 'id'
                    );
            $table->char('telefono', length: 20)->nullable();
            $table->char('ruc', length: 20)->nullable();
            $table->char('banco', length: 50)->nullable();
            $table->char('cta_banco', length: 50)->nullable();
            $table->char('cta_cci', length: 50)->nullable();
            $table->char('cta_detraccion', length: 50)->nullable();
            $table->decimal('costo', 10, 2)->default(0.00);
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultors');
    }
};
