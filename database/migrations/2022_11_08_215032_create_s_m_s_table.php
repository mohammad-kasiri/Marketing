<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('s_m_s', function (Blueprint $table) {
            $table->id();
            $table->string('template_id');
            $table->string('text');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('s_m_s');
    }
};
