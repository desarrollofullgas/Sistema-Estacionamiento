<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tarifas', function (Blueprint $table) {
            $table->id();
            $table->enum('tiempo',['15 minutos','30 minutos','45 minutos','Hora','Fracción','Día','Semana','Mes'])->default('15 minutos');
            //$table->string('tiempo');
            $table->string('descripcion',100)->nullable();
            $table->float('costo',10,2)->defult(0);
            $table->integer('jerarquia')->defult(0);

            $table->unsignedBigInteger('tipo_id');        
            $table->foreign('tipo_id')->references('id')->on('tipos');
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
        Schema::dropIfExists('tarifas');
    }
};
