<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('nit', 50)->index();
            $table->string('legal_representative');
            $table->string('company_type', 80);
            $table->string('department_code', 2);
            $table->string('municipality_code', 5);
            $table->text('address');
            $table->date('affiliation_date');
            $table->json('services');
            $table->string('withholding_status', 20)->nullable();
            $table->string('billing_cutoff', 120)->nullable();
            $table->text('operating_sites')->nullable();
            $table->json('cross_sell_opportunities')->nullable();
            $table->text('observations');
            $table->string('category', 1)->nullable();
            $table->string('status', 20)->default('prospecto')->index();
            $table->timestamps();

            $table->foreign('department_code')
                ->references('code')
                ->on('departments')
                ->restrictOnDelete();
            $table->foreign('municipality_code')
                ->references('code')
                ->on('municipalities')
                ->restrictOnDelete();
            $table->index(['created_at', 'id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
