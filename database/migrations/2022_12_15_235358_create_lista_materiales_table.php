<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListaMaterialesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_materiales', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_project');
            $table->foreign('id_project')
            ->references('id')
            ->on('projects')
            ->onDelete('cascade');
            $table->string('folio');
            $table->string('description');
            $table->string('modelo');
            $table->string('fabricante');
            $table->integer('cantidad');
            $table->string('unidad');
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
        Schema::dropIfExists('lista_materiales');
    }
}
