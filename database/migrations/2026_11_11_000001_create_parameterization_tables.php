<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('parameterization', function (Blueprint $table) {
            $table->id();
            $table->char('category', 1)->unique();
            $table->unsignedSmallInteger('average_frequency_init');
            $table->unsignedSmallInteger('average_frequency_end');
            $table->unsignedBigInteger('volume_gallons_init');
            $table->unsignedBigInteger('volume_gallons_end');
            $table->unsignedSmallInteger('maximum_last_collection');
            $table->timestamps();
        });

        Schema::create('parameterization_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('analysis_months')->default(1);
            $table->decimal('decrease_quantity_percentage', 5, 2)->default(10);
            $table->decimal('decrease_frequency_percentage', 5, 2)->default(10);
            $table->unsignedSmallInteger('inactivity_days')->default(30);
            $table->timestamp('last_sync_at')->nullable();
            $table->timestamps();
        });

        $now = now();

        DB::table('parameterization')->insert([
            [
                'category' => 'A',
                'average_frequency_init' => 10,
                'average_frequency_end' => 20,
                'volume_gallons_init' => 2000,
                'volume_gallons_end' => 2500,
                'maximum_last_collection' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'B',
                'average_frequency_init' => 6,
                'average_frequency_end' => 9,
                'volume_gallons_init' => 1500,
                'volume_gallons_end' => 1999,
                'maximum_last_collection' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category' => 'C',
                'average_frequency_init' => 1,
                'average_frequency_end' => 5,
                'volume_gallons_init' => 1,
                'volume_gallons_end' => 1499,
                'maximum_last_collection' => 18,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);

        DB::table('parameterization_settings')->insert([
            'analysis_months' => 1,
            'decrease_quantity_percentage' => 10,
            'decrease_frequency_percentage' => 10,
            'inactivity_days' => 30,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('parameterization_settings');
        Schema::dropIfExists('parameterization');
    }
};
