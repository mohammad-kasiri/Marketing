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
        Schema::create('assignment_sales_case', function (Blueprint $table) {
            $table->unsignedBigInteger('assignment_id');
            $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');

            $table->unsignedBigInteger('sales_cases_id');
            $table->foreign('sales_cases_id')->references('id')->on('sales_cases')->onDelete('cascade');

            $table->primary(['assignment_id' , 'sales_cases_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignment_sales_case');
    }
};
