<?php

use Illuminate\Database\Eloquent\Scope;
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
        Schema::dropIfExists('invoices');
        Schema::create('invoices', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
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
                ->foreignUuid('payer_id')
                ->nullable()
                ->references('id')
                ->on('customers')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('number')->nullable();
            $table->string('status')->default('draft'); // draft, sent, paid, overdue, cancelled, refunded
            $table->string('currency')->nullable();
            $table->double('currency_rate')->default(1);
            $table->string('payment_method')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('customer_city')->nullable();
            $table->string('customer_zip_code')->nullable();
            $table->string('customer_country')->nullable();
            $table->string('payer_name')->nullable();
            $table->string('payer_address')->nullable();
            $table->string('payer_city')->nullable();
            $table->string('payer_zip_code')->nullable();
            $table->string('payer_country')->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->text('notes')->nullable();
            $table->string('discount_type')->nullable(); // fixed, percentage
            $table
                ->decimal('discount', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->decimal('tax', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->decimal('total', 10, 2)
                ->default(0)
                ->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('invoice_items');
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('invoice_id')
                ->nullable()
                ->references('id')
                ->on('invoices')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->foreignUuid('product_id')->nullable();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table->string('type')->nullable(); // service, product
            $table
                ->decimal('quantity', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->decimal('price', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->decimal('tax', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->decimal('discount', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->decimal('total', 10, 2)
                ->default(0)
                ->nullable();
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
        Schema::disableForeignKeyConstraints('invoices');
        Schema::disableForeignKeyConstraints('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('invoice_items');
    }
};
