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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('type')->nullable();
            $table->string('currency')->nullable();
            $table->string('description')->nullable();
            $table->double('opening_balance', 10, 2)->nullable()->default(0);
            $table->dateTime('date_opened')->nullable();
            $table->dateTime('date_closed')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('bank_contact')->nullable();
            $table->string('iban')->nullable();
            $table->string('bic')->nullable();
            $table->boolean('is_default')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(1);
            $table->foreignUuid('open_banking_id')->nullable()->references('id')->on('open_banking')->nullOnDelete()->cascadeOnUpdate();
            $table->string('integration')->nullable(); // stripe, paypal etc.
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
