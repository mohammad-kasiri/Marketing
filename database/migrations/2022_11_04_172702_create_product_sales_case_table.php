<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_sales_case', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');

            $table->unsignedBigInteger('sales_case_id');
            $table->foreign('sales_case_id')->references('id')->on('sales_cases')->onDelete('cascade');

            $table->primary(['product_id' , 'sales_case_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_sales_case');
    }
};
