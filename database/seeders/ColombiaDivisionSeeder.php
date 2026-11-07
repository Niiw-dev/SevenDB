<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ColombiaDivisionSeeder extends Seeder
{
    public function run(): void
    {
        // DANE DIVIPOLA 2024, downloaded from datos.gov.co (gdxc-w37w).
        // Dataset license: Creative Commons Attribution-ShareAlike 4.0.
        $catalog = json_decode(
            File::get(database_path('divipola-dane-2024.json')),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        $now = now();
        $departments = [];
        $municipalities = [];

        foreach ($catalog as $row) {
            $departments[$row['cod_dpto']] = [
                'code' => $row['cod_dpto'],
                'name' => $row['dpto'],
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $municipalities[] = [
                'code' => $row['cod_mpio'],
                'department_code' => $row['cod_dpto'],
                'name' => $row['nom_mpio'],
                'search_name' => Str::lower(Str::ascii($row['nom_mpio'])),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('departments')->upsert(
            array_values($departments),
            ['code'],
            ['name', 'updated_at']
        );

        foreach (array_chunk($municipalities, 500) as $chunk) {
            DB::table('municipalities')->upsert(
                $chunk,
                ['code'],
                ['department_code', 'name', 'updated_at']
            );
        }
    }
}
