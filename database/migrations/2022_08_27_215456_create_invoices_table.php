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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('price')->default(0);
            $table->string('paid_by')->nullable();

            $table->string('account_number')->nullable();
            $table->string('gateway_tracking_code')->nullable();
            $table->string('order_number')->nullable();

            $table->string('description' , 500)->nullable();
            $table->string('status')->default('sent');
            $table->timestamp('paid_at')->nullable();

            $table->unsignedBigInteger('suspicious_with')->nullable();
            $table->foreign('suspicious_with')->references('id')->on('invoices')->onDelete('cascade');

            $table->softDeletes();
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
        Schema::dropIfExists('invoices');
    }
};
