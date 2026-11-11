<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recolecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clientes')->cascadeOnDelete();
            $table->decimal('gallons', 12, 2);
            $table->date('collected_at');
            $table->timestamps();

            $table->index(['client_id', 'collected_at']);
            $table->index('collected_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recolecciones');
    }
};
