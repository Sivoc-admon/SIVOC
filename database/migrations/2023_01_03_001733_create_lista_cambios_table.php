<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaCambiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_cambios', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_lista_materiales');
            $table->foreign('id_lista_materiales')
            ->references('id')
            ->on('lista_materiales')
            ->onDelete('cascade');
            $table->unsignedInteger('id_user');
            $table->foreign('id_user')
            ->references('id')
            ->on('users')
            ->onDelete('cascade');
            $table->string('folio');
            $table->string('description');
            $table->string('modelo');
            $table->string('fabricante');
            $table->integer('cantidad');
            $table->string('unidad');
            $table->string('tipo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lista_cambios');
    }
}
