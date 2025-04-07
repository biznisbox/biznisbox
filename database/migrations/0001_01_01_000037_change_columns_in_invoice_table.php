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
        Schema::table('invoices', function (Blueprint $table) {
            $table->renameColumn('payment_method', 'payment_method_id');
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->renameColumn('payment_method', 'payment_method_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->renameColumn('payment_method_id', 'payment_method');
        });

        Schema::table('bills', function (Blueprint $table) {
            $table->renameColumn('payment_method_id', 'payment_method');
        });
    }
};
