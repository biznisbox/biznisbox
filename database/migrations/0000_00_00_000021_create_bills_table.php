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
        Schema::dropIfExists('bills');
        Schema::create('bills', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('number')->nullable();
            $table
                ->foreignUuid('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
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
                ->string('status')
                ->default('draft')
                ->nullable();
            $table->date('date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('total')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('bill_items');
        Schema::create('bill_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('bill_id')
                ->nullable()
                ->references('id')
                ->on('bills')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table
                ->foreignUuid('product_id')
                ->nullable()
                ->references('id')
                ->on('products')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table
                ->decimal('quantity', 10, 2)
                ->default(0)
                ->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table
                ->decimal('total')
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
        Schema::disableForeignKeyConstraints('bill_items');
        Schema::disableForeignKeyConstraints('bills');
        Schema::dropIfExists('bills');
        Schema::dropIfExists('bill_items');
    }
};
