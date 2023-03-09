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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('from_user_id')->nullable();
            $table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('to_user_id')->nullable();
            $table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('sales_case_status_id')->nullable();
            $table->foreign('sales_case_status_id')->references('id')->on('sales_case_statuses')->onDelete('cascade');

            $table->unsignedBigInteger('failure_reason_id')->nullable();
            $table->foreign('failure_reason_id')->references('id')->on('failure_reasons')->onDelete('cascade');

            $table->bigInteger('count');

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
        Schema::dropIfExists('assignments');
    }
};
