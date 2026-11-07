<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Agrega la columna que almacena la contraseña SIN hash del usuario.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users', 'deciphered_password')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('deciphered_password')
                ->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('users', 'deciphered_password')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('deciphered_password');
            });
        }
    }
};
