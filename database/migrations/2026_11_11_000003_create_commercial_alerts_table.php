<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commercial_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('type', 30);
            $table->string('status', 20)->default('active');
            $table->decimal('current_value', 14, 2)->nullable();
            $table->decimal('previous_value', 14, 2)->nullable();
            $table->decimal('variation_percentage', 8, 2)->nullable();
            $table->timestamp('detected_at');
            $table->timestamp('acknowledged_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();

            $table->index(['client_id', 'type', 'status']);
            $table->index(['status', 'acknowledged_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commercial_alerts');
    }
};
