<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pieces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')
                  ->constrained()
                  ->cascadeOnDelete();
            $table->string('name');
            $table->decimal('peso_teorico', 10, 3);
            $table->decimal('peso_real', 10, 3)->nullable();
            $table->enum('estado', ['pendiente', 'fabricada'])->default('pendiente');
            $table->timestamp('fecha_fabricacion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pieces');
    }
};
