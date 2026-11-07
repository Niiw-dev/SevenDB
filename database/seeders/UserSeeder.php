<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Crea el usuario administrador inicial del sistema.
     *
     * @return void
     */
    public function run()
    {
        $usuario = User::create([
            'name' => 'Administrador Eco 7',
            'email' => 'admin@eco7.com',
            'password' => Hash::make('Demopass_123'),
            'rol' => User::ROL_ADMINISTRADOR,
            'estado' => User::ESTADO_ACTIVO,
            'deciphered_password' => 'Demopass_123',
        ]);

        $usuario->fijarContrasena('Demopass_123');
        $usuario->save();
    }
}
