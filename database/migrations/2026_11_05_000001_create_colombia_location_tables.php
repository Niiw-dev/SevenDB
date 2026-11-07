<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->string('code', 2)->primary();
            $table->string('name', 120);
            $table->timestamps();
        });

        Schema::create('municipalities', function (Blueprint $table) {
            $table->string('code', 5)->primary();
            $table->string('department_code', 2);
            $table->string('name', 160);
            $table->string('search_name', 160)->index();
            $table->timestamps();

            $table->foreign('department_code')
                ->references('code')
                ->on('departments')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
            $table->index(['department_code', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('municipalities');
        Schema::dropIfExists('departments');
    }
};
