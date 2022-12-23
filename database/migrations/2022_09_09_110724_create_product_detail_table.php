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
        Schema::create('product_detail', function (Blueprint $table) {
            $table->increments('ProDe_Id');
            $table->string('Pro_Name',250);
            $table->double('Pro_Price',8,2);
            $table->string('Pro_Unit', 50);
            $table->string('Pro_Avatar',250)->nullable();         
            $table->longText('shortDes')->nullable();
            $table->longText('longDes')->nullable();
            $table->boolean('is_Published')->default(true);

            $table->unsignedInteger('Pro_Id');
            $table->foreign('Pro_Id')->references('Pro_Id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productDetail');
    }
};
