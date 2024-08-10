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
        Schema::create('currencies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code', 3)->unique();
            $table->string('symbol', 5)->nullable();
            $table->string('exchange_rate', 50)->nullable()->default(1);
            $table->string('status', 10)->default('active');
            $table->char('decimal_separator', 5)->default('.');
            $table->char('thousand_separator', 5)->default(',');
            $table->string('number_of_decimal', 5)->default('2');
            $table->string('placement', 50)->default('after');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('currencies');
    }
};
