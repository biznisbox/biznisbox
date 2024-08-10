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
        Schema::create('open_banking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bank_id')->nullable();
            $table->string('iban')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_logo')->nullable();
            $table->text('payment_available')->nullable();
            $table->string('account_id')->nullable();
            $table->string('agreement_id')->nullable();
            $table->string('agreement_status')->nullable();
            $table->string('requisition_id')->nullable();
            $table->string('requisition_status')->nullable();
            $table->integer('transaction_total_days')->nullable();
            $table->string('connection_status')->nullable();
            $table->timestamp('connection_valid_until')->nullable();
            $table->timestamp('last_transaction_sync')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open_banking');
    }
};
