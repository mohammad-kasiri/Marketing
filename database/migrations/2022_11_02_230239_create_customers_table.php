<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('city_id')->nullable();

            $table->string('first_name', 60)->nullable();
            $table->string('last_name', 60)->nullable();
            $table->string('mobile', 13)->unique();
            $table->string('email', 50)->nullable();
            $table->timestamp('birth_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('possibility_of_purchase')->default(1);
            $table->text('description')->nullable();
            $table->string('status')->default('created');
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
        Schema::dropIfExists('customers');
    }
};
