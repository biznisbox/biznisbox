<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('transactions');
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('invoice_id')
                ->nullable()
                ->references('id')
                ->on('invoices')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('payment_id')
                ->nullable()
                ->references('id')
                ->on('online_payment')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('bill_id')
                ->nullable()
                ->references('id')
                ->on('bills')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('customer_id')
                ->nullable()
                ->references('id')
                ->on('customers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('vendor_id')
                ->nullable()
                ->references('id')
                ->on('vendors')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('account_id')
                ->nullable()
                ->references('id')
                ->on('accounts')
                ->nullOnDelete()
                ->cascadeOnUpdate(); // account_id is the account that the transaction is recorded in
            $table
                ->foreignUuid('category_id')
                ->nullable()
                ->references('id')
                ->on('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('number'); // transaction number
            $table->string('type'); // expense, income, transfer
            $table->string('name'); // transaction name
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
            $table
                ->foreignUuid('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate();
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
        Schema::disableForeignKeyConstraints('transactions');
        Schema::dropIfExists('transactions');
    }
};
