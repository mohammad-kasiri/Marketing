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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id');
            $table->unsignedBigInteger('agent_id');
            $table->unsignedBigInteger('total');
            $table->unsignedBigInteger('percentage');
            $table->timestamp('from_date');
            $table->timestamp('to_date');
            $table->string('status')->default('created');
            $table->string('tracing_number')->nullable();
            $table->string('description' , 300)->nullable();
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
        Schema::dropIfExists('transactions');
    }
};
