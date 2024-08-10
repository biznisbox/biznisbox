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
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->nullable()->references('id')->on('invoices')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('bill_id')->nullable()->references('id')->on('bills')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('customer_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('supplier_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('account_id')->nullable()->references('id')->on('accounts')->nullOnDelete()->cascadeOnUpdate(); // account_id is the account that the transaction is recorded in
            $table->foreignUuid('category_id')->nullable()->references('id')->on('categories')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('payment_id')->nullable()->references('id')->on('online_payments')->nullOnDelete()->cascadeOnUpdate();
            $table->string('bank_transaction_id')->nullable(); // bank transaction id (for open banking)
            $table->string('number')->nullable(); // transaction number
            $table->string('type')->nullable()->default('expense'); // expense, income, transfer, etc
            $table->foreignUuid('from_account')->nullable()->references('id')->on('accounts')->nullOnDelete()->cascadeOnUpdate(); // for transfer transactions
            $table->foreignUuid('to_account')->nullable()->references('id')->on('accounts')->nullOnDelete()->cascadeOnUpdate(); // for transfer transactions
            $table->string('name')->nullable(); // transaction name
            $table->text('description')->nullable(); // memo
            $table->double('amount', 10, 2); // amount
            $table->string('currency')->nullable(); // currency
            $table->double('exchange_rate', 10, 2)->nullable(); // exchange rate for currency conversion
            $table->string('payment_method')->nullable(); // cash, bank, paypal, etc
            $table->string('reference')->nullable(); // check number, paypal transaction id, etc
            $table->string('status')->nullable(); // pending, completed, etc
            $table->timestamp('date')->nullable(); // transaction date (not created_at)
            $table->boolean('reconciled')->default(false); // reconciled or not
            $table->timestamp('reconciled_at')->nullable(); // reconciled date
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
