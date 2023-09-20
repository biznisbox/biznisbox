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
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('number')->nullable();
            $table->string('name')->index();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->double('sell_price', 15, 4)->nullable();
            $table->double('buy_price', 15, 4)->nullable();
            $table->double('stock', 15, 4)->nullable();
            $table->double('stock_min', 15, 4)->nullable();
            $table->double('stock_max', 15, 4)->nullable();
            $table->string('unit')->nullable();
            $table->string('tax')->nullable();
            $table->boolean('active')->default(true);
            $table->string('type')->nullable();
            $table->string('barcode')->nullable();
            $table->string('sku')->nullable();
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
        Schema::dropIfExists('products');
    }
};
