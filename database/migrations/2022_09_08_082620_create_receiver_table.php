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
        Schema::create('receiver', function (Blueprint $table) {
            $table->increments('Re_Id');
            $table->string('name',250);
            $table->string('phone',250);
            $table->string('address',250);
            $table->boolean('is_Default')->default(false);
            $table->boolean('is_Chosen')->default(false);

            $table->unsignedInteger('Mem_Id');
            $table->foreign('Mem_Id')->references('Mem_Id')->on('members');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receiver');
    }
};
