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
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('customer_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('payer_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('sales_person_id')->nullable()->references('id')->on('employees')->nullOnDelete()->cascadeOnUpdate();
            $table->string('type')->nullable(); // invoice, proforma, recurring, pos
            $table->string('number')->nullable();
            $table->string('status')->default('draft'); // draft, sent, paid, overdue, cancelled, refunded
            $table->string('currency')->nullable();
            $table->double('currency_rate')->default(1);
            $table->string('default_currency')->nullable(); // Used to store the default currency of the company at the moment of the invoice creation
            $table->string('payment_method')->nullable(); // cash, check, credit_card, bank_transfer, paypal, stripe
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
            $table
                ->foreignUuid('payer_address_id')
                ->nullable()
                ->references('id')
                ->on('partner_addresses')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('payer_name')->nullable();
            $table->string('payer_address')->nullable();
            $table->string('payer_city')->nullable();
            $table->string('payer_zip_code')->nullable();
            $table->string('payer_country')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable(); // Notes of the invoice (internal notes)
            $table->text('footer')->nullable(); // Footer of the invoice (terms and conditions)
            $table->string('discount_type')->nullable(); // fixed, percentage
            $table->decimal('discount', 10, 2)->default(0)->nullable();
            $table->decimal('tax', 10, 2)->default(0)->nullable(); // If is added to the total amount
            $table->decimal('total', 10, 2)->default(0)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('invoice_id')->nullable()->references('id')->on('invoices')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('product_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity', 10, 2)->default(0)->nullable();
            $table->decimal('price', 10, 2)->default(0)->nullable();
            $table->decimal('tax', 10, 2)->default(0)->nullable();
            $table->string('tax_type')->nullable(); // fixed, percentage
            $table->decimal('discount', 10, 2)->default(0)->nullable();
            $table->string('discount_type')->nullable(); // fixed, percentage
            $table->decimal('total', 10, 2)->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
    }
};
