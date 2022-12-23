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
        Schema::create('order_cus', function (Blueprint $table) {
            $table->increments('ORD_Id');
            
            $table->string('ORD_Code',250);
            $table->dateTime('ORD_DateTime');

            $table->string('ORD_Name',250);
            $table->string('ORD_Phone',250);
            $table->string('ORD_Address',250);
            $table->string('ORD_Email',250)->nullable();;

            $table->string('ORD_CusNote',250)->nullable();
            $table->string('ORD_AdNote',250)->nullable();

            $table->unsignedInteger('Cus_Id')->nullable();
            $table->foreign('Cus_Id')->references('Cus_Id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_cus');
    }
};
