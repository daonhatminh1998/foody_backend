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
        Schema::create('cart_detail', function (Blueprint $table) {
            $table->increments('CartDe_Id');
            $table->double('CartDe_Quantity',8,2);

            $table->unsignedInteger('ProDe_Id');
            $table->foreign('ProDe_Id')->references('ProDe_Id')->on('product_detail');

            $table->unsignedInteger('Cart_Id');
            $table->foreign('Cart_Id')->references('Cart_Id')->on('carts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cart_detail');
    }
};
