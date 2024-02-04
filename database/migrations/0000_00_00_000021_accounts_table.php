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
        Schema::dropIfExists('accounts');
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // Name of the account (e.g. "My Bank")
            $table->string('type')->nullable(); // bank, cash, credit card, online account
            $table->string('currency')->nullable(); // USD, EUR, GBP, etc.
            $table->string('description')->nullable(); // bank, cash, credit card, online account
            $table->double('opening_balance', 10, 2)->nullable()->default(0); // opening balance
            $table->double('current_balance', 10, 2)->nullable()->default(0); // current balance
            $table->string('bank_name')->nullable(); // for bank accounts
            $table->string('bank_address')->nullable(); // bank address
            $table->string('bank_contact')->nullable(); // phone or email
            $table->string('iban')->nullable(); // International Bank Account Number
            $table->string('bic')->nullable(); // Bank Identifier Code (SWIFT code)
            $table->boolean('is_default')->nullable()->default(0); // 0 = false, 1 = true
            $table->boolean('is_active')->nullable()->default(1); // 0 = inactive, 1 = active
            $table->foreignUuid('open_banking_id')->nullable()->references('id')->on('open_banking')->nullOnDelete()->cascadeOnUpdate();
            $table->string('integration')->nullable(); // stripe, paypal etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accounts');
    }
};
