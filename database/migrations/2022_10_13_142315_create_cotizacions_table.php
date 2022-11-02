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
        Schema::create('cotizacions', function (Blueprint $table) {
            $table->id();
            $table->string('descripcion',1000);
            $table->date('salida');
            $table->date('regreso');
            $table->integer('adultos')->default(0);
            $table->integer('menores')->default(0);
            $table->integer('infantes')->default(0);
            $table->decimal('total',10,2)->default(0);
            $table->decimal('anticipo',10,2)->default(0);
            $table->enum('estatus',['Pendiente','Pagada','Cancelada'])->default('Pagada');
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
        Schema::dropIfExists('cotizacions');
    }
};
