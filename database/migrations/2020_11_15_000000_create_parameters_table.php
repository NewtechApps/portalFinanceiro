<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Parameters;

class CreateParametersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parameters', function (Blueprint $table) {
            $table->string('name',30)->unique();
            $table->string('value')->nullable();
        });


        $param = new Parameters();
        $param->name  = 'email';
        $param->value = env('MAIL_FROM_ADDRESS');
        $param->save();

        $param = new Parameters();
        $param->name  = 'wsdlBoletos';
        $param->value = '';
        $param->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parameters');
    }
}
