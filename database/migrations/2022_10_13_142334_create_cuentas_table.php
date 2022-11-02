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
        Schema::create('cuentas', function (Blueprint $table) {
            $table->id();
            $table->string('operadora');
            $table->decimal('precioadulto', 10,2)->default(0);
            $table->decimal('preciojr', 10,2)->default(0);
            $table->decimal('preciomenor', 10,2)->default(0);
            $table->decimal('total', 10,2)->default(0);
            $table->enum('estatus',['Pendiente','Pagado','Cancelado'])->default('Pendiente');
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
        Schema::dropIfExists('cuentas');
    }
};
