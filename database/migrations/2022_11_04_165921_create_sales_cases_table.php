<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sales_cases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('agent_id')->nullable();
            $table->foreign('agent_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('customer_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');

            $table->unsignedBigInteger('status_id')->nullable();
            $table->foreign('status_id')->references('id')->on('sales_case_statuses')->onDelete('cascade');

            $table->unsignedBigInteger('tag_id')->nullable();
            $table->foreign('tag_id')->references('id')->on('sales_case_tags')->onDelete('cascade');

            $table->unsignedBigInteger('failure_reason_id')->nullable();
            $table->foreign('failure_reason_id')->references('id')->on('failure_reasons')->onDelete('cascade');

            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->string('failure_reason')->nullable();

            $table->text('admin_note')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_promoted')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales_cases');
    }
};
