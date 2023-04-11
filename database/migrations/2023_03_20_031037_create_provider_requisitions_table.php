<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_requisitions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_detail_requisition');
            $table->foreign('id_detail_requisition')
            ->references('id')
            ->on('detail_requisitions')
            ->onDelete('cascade');
            $table->integer('num_item')->unsigned();
            $table->string('name', 250);
            $table->integer('unit_price')->unsigned();
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
        Schema::dropIfExists('provider_requisitions');
    }
}
