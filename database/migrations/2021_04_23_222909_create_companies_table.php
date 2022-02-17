<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('razonSocial',255);
            $table->string('nombreComercial',255)->nullable();
            $table->string('ruc',13)->unique();
            $table->string('estab'); //max 3
            $table->string('ptoEmi');  // max 3
            $table->string('dirMatriz',500);
            $table->string('dirEstablecimiento',500);
            $table->string('telefono',10)->nullable();
            $table->string('email')->nullable();
            $table->integer('ambiente');  //1 0 2
            $table->integer('tipoEmision'); // 1
            $table->string('contribuyenteEspecial'); //5368
            $table->string('obligadoContabilidad'); // si no
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
