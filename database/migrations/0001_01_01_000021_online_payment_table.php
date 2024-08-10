<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('online_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->nullable();
            $table->string('payment_method')->nullable(); // stripe, paypal, etc
            $table->string('payment_id')->nullable(); // stripe payment id, paypal payment id, etc
            $table->string('type')->nullable(); // card, bank, etc
            $table->string('amount')->nullable(); // amount paid
            $table->string('currency')->nullable(); // currency paid in
            $table->string('description')->nullable(); // description of payment
            $table->string('status')->nullable(); // success, failed, pending, etc
            $table->text('payment_response')->nullable(); // response from payment gateway
            $table->string('payment_ref')->nullable(); // reference number from payment gateway
            $table->string('payment_document_type')->nullable(); // invoice, receipt, etc
            $table->uuid('payment_document_id')->nullable(); // invoice id, receipt id, etc
            $table->string('key')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_payments');
    }
};
