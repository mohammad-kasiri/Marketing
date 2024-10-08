<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('provinces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('province_id')->nullable();  //BE Carefull About Cascade
            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
            $table->string('name' , 20);
        });
    }
    public function down()
    {
        Schema::dropIfExists('provinces');
    }
};
