<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('name');
            $table->string('job_title');
            $table->string('area', 160);
            $table->string('department_code', 2);
            $table->string('municipality_code', 5);
            $table->string('phone', 21);
            $table->string('email');
            $table->boolean('is_primary')->default(false);
            $table->timestamps();

            $table->foreign('department_code')
                ->references('code')
                ->on('departments')
                ->restrictOnDelete();
            $table->foreign('municipality_code')
                ->references('code')
                ->on('municipalities')
                ->restrictOnDelete();
            $table->index(['client_id', 'created_at', 'id']);
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE UNIQUE INDEX contacts_one_primary_per_client ON contacts (client_id) WHERE is_primary = TRUE');
        } elseif (DB::getDriverName() === 'sqlite') {
            DB::statement('CREATE UNIQUE INDEX contacts_one_primary_per_client ON contacts (client_id) WHERE is_primary = 1');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};