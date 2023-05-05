<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('evento_id')->nullable()->unsigned();
                $table->foreign('evento_id')->references('id')->on('eventos');
            $table->bigInteger('puesto_id')->nullable()->unsigned();
                $table->foreign('puesto_id')->references('id')->on('puestos');
            $table->string('nombre',255);
            $table->string('metodo_pago',255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
