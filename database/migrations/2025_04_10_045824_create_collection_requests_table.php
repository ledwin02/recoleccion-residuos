<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('collection_requests', function (Blueprint $table) {
            $table->id();

            // Foreign Keys
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('waste_type_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('company_id')
                ->constrained('collector_companies')
                ->onDelete('cascade');

            // Datos de la recolección
            $table->date('collection_date');
            $table->time('collection_time')->nullable();

            // Frecuencia
            $table->enum('frequency', ['weekly', 'biweekly', 'monthly', 'on_demand'])
                ->default('on_demand');

            // Recolección bajo demanda
            $table->boolean('is_on_demand')->default(false); // ← importante si está en el modelo

            // Solo para reciclables: peso
            $table->decimal('weight', 8, 2)->nullable();

            // Puntos y notas
            $table->integer('points_earned')->nullable();
            $table->text('notes')->nullable();

            // Estado
            $table->enum('status', ['pending', 'in_progress', 'completed', 'canceled'])
                ->default('pending'); // ← adaptado al modelo

            // Índices
            $table->index('status');
            $table->index('collection_date');

            $table->timestamps();
        });
    }
 public function down(): void
    {
        Schema::dropIfExists('collection_requests');
    }
};
