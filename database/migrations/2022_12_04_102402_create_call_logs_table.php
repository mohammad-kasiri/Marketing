<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('call_logs', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('from');
            $table->string('to');
            $table->string('uid');
            $table->string('cuid');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('call_logs');
    }
};
