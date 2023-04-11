<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionFileItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisition_file_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_detail_requisition');
            $table->foreign('id_detail_requisition')
            ->references('id')
            ->on('detail_requisitions')
            ->onDelete('cascade');
            $table->string('name', 150);
            $table->string('ruta');
            $table->text('comment');
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
        Schema::dropIfExists('requisition_file_items');
    }
}
