<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('sales_case_id')->nullable();
            $table->foreign('sales_case_id')->references('id')->on('sales_cases')->onDelete('cascade');

            $table->string('title');

            $table->string('note', 200)->nullable();
            $table->timestamp('remind_at');
            $table->timestamp('done_at')->nullable();

            $table->boolean('first_notify')->default(false);
            $table->boolean('second_notify')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};
