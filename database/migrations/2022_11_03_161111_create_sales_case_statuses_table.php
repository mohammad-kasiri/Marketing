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
        Schema::create('sales_case_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name', 40);
            $table->integer('sort')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_first_step')->default(false);
            $table->boolean('is_before_last_step')->default(false);
            $table->boolean('is_last_step')->default(false);
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
        Schema::dropIfExists('sales_case_statuses');
    }
};
