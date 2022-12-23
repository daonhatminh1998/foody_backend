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
        Schema::create('order_mem_detail', function (Blueprint $table) {
            $table->increments('ORDe_Id');
            $table->double('ORDe_Quantity',8,2);
            $table->double('ORDe_Price',8,2);

            $table->unsignedInteger('ProDe_Id');
            $table->foreign('ProDe_Id')->references('ProDe_Id')->on('product_detail');

            $table->unsignedInteger('ORD_Id');
            $table->foreign('ORD_Id')->references('ORD_Id')->on('order_mem');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_mem_detail');
    }
};
