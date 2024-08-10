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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('category_id')->nullable()->constrained('categories')->nullOnDelete()->cascadeOnUpdate();
            $table->string('number')->nullable();
            $table->string('name')->index();
            $table->string('type')->nullable();
            $table->longText('description')->nullable();
            $table->double('sell_price', 15, 4)->nullable();
            $table->double('buy_price', 15, 4)->nullable();
            $table->double('stock', 15, 4)->nullable();
            $table->double('stock_min', 15, 4)->nullable();
            $table->double('stock_max', 15, 4)->nullable();
            $table->string('unit')->nullable();
            $table->string('tax')->nullable();
            $table->boolean('active')->default(true);
            $table->string('barcode')->nullable();
            $table->string('additional_info')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
