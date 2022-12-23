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
        Schema::create('members', function (Blueprint $table) {
            $table->increments('Mem_Id');
            
            $table->string('name',255);
            $table->string('email')->unique();
            
            $table->string('avatar')->nullable();
            $table->string('bgimg',255)->nullable();

            $table->string("username",255)->unique();
            $table->string('password',255);

            $table->string('api_token',255)->nullable();
            $table->dateTime('api_expired')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
