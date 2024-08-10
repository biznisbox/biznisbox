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
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->nullable();
            $table->foreignUuid('supplier_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->string('supplier_name')->nullable();
            $table
                ->foreignUuid('supplier_address_id')
                ->nullable()
                ->references('id')
                ->on('partner_addresses')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('supplier_address')->nullable();
            $table->string('supplier_city')->nullable();
            $table->string('supplier_zip_code')->nullable();
            $table->string('supplier_country')->nullable();
            $table->string('currency')->nullable();
            $table->double('currency_rate')->default(1);
            $table->string('reference')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->default('draft')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->string('notes')->nullable();
            $table->string('footer')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('bill_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('bill_id')->nullable()->references('id')->on('bills')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('product_id')->nullable()->references('id')->on('products')->nullOnDelete()->cascadeOnUpdate();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table->decimal('quantity', 10, 2)->default(0)->nullable();
            $table->decimal('tax', 10, 2)->nullable();
            $table->string('tax_type')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->string('discount_type')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('total')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_items');
        Schema::dropIfExists('bills');
    }
};
