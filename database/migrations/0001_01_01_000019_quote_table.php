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
        Schema::create('quotes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('payer_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('sales_person_id')->nullable()->references('id')->on('employees')->nullOnDelete()->cascadeOnUpdate();
            $table->string('type')->nullable();
            $table->string('number')->nullable();
            $table->string('status')->default('draft'); // draft, sent, accepted, declined, cancelled
            $table->string('currency')->nullable();
            $table->string('default_currency')->nullable(); // default currency of the company
            $table->double('currency_rate')->default(1);
            $table->string('payment_method')->nullable();
            $table->string('customer_name')->nullable();
            $table
                ->foreignUuid('customer_address_id')
                ->nullable()
                ->references('id')
                ->on('partner_addresses')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('customer_address')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_zip_code')->nullable();
            $table->string('customer_country')->nullable();
            $table->string('payer_name')->nullable();
            $table
                ->foreignUuid('payer_address_id')
                ->nullable()
                ->references('id')
                ->on('partner_addresses')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('payer_address')->nullable();
            $table->string('payer_city')->nullable();
            $table->string('payer_zip_code')->nullable();
            $table->string('payer_country')->nullable();
            $table->date('date')->nullable();
            $table->date('valid_until')->nullable();
            $table->text('notes')->nullable();
            $table->text('footer')->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('discount', 10, 2)->default(0)->nullable();
            $table->decimal('tax', 10, 2)->default(0)->nullable();
            $table->decimal('total', 10, 2)->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('quote_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('quote_id')->nullable()->references('id')->on('quotes')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('product_id')->nullable()->references('id')->on('products')->nullOnDelete()->cascadeOnUpdate();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('quantity', 10, 2)->default(0)->nullable();
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->decimal('tax', 10, 2)->default(0)->nullable();
            $table->string('tax_type')->nullable(); // fixed, percent
            $table->decimal('discount', 10, 2)->default(0)->nullable();
            $table->string('discount_type')->nullable(); // fixed, percent
            $table->decimal('total', 10, 2)->default(0)->nullable();
            $table->string('unit')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quote_items');
        Schema::dropIfExists('quotes');
    }
};
