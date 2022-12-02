<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('s_m_s_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sales_case_id');
            $table->foreign('sales_case_id')->references('id')->on('sales_cases')->onDelete('cascade');

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('template_id')->nullable();
            $table->string('text');

            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('s_m_s_logs');
    }
};
