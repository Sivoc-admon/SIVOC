<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableListaMaterialesFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lista_materiales_files', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_lista_materiales_folder');
            $table->foreign('id_lista_materiales_folder')
            ->references('id')
            ->on('lista_materiales_folders')
            ->onDelete('cascade');
            $table->string('name', 250);
            $table->string('ruta');
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
        Schema::dropIfExists('lista_materiales_files');
    }
}
