<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Usuario;    

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('login',16)->unique();
            $table->string('password');
            $table->string('name');
            $table->string('email')->unique();
            $table->char('tipo',1);
            $table->char('ativo',1);
            $table->char('primeiro',1);
            $table->rememberToken();
            $table->timestamps();
        });



        $usuario = new Usuario();
        $usuario->name   = 'Administrador do Portal';
        $usuario->email  = env('MAIL_FROM_ADDRESS');
        $usuario->login  = 'portal.admin';
        $usuario->tipo   = 'A';
        $usuario->ativo  = 'A';
        $usuario->primeiro = "N";
        $usuario->password = Hash::make("admin123");
        $usuario->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario');
    }
}
