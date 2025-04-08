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
        if (Schema::hasColumn('transactions', 'payment_method')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->renameColumn('payment_method', 'payment_method_id');
            });
        }

        if (Schema::hasColumn('invoices', 'payment_method')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->renameColumn('payment_method', 'payment_method_id');
            });
        }

        if (Schema::hasColumn('bills', 'payment_method')) {
            Schema::table('bills', function (Blueprint $table) {
                $table->renameColumn('payment_method', 'payment_method_id');
            });
        }

        if (Schema::hasColumn('quotes', 'payment_method')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->renameColumn('payment_method', 'payment_method_id');
            });
        }

        // Add column to archive table
        if (!Schema::hasColumn('archive', 'document_type_id')) {
            Schema::table('archive', function (Blueprint $table) {
                $table
                    ->foreignUuid('document_type_id')
                    ->nullable()
                    ->references('id')
                    ->on('categories')
                    ->after('user_id')
                    ->onDelete('set null')
                    ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('transactions', 'payment_method_id')) {
            Schema::table('transactions', function (Blueprint $table) {
                $table->renameColumn('payment_method_id', 'payment_method');
            });
        }
        if (Schema::hasColumn('invoices', 'payment_method')) {
            Schema::table('invoices', function (Blueprint $table) {
                $table->renameColumn('payment_method', 'payment_method_id');
            });
        }

        if (Schema::hasColumn('bills', 'payment_method_id')) {
            Schema::table('bills', function (Blueprint $table) {
                $table->renameColumn('payment_method_id', 'payment_method');
            });
        }

        if (Schema::hasColumn('quotes', 'payment_method_id')) {
            Schema::table('quotes', function (Blueprint $table) {
                $table->renameColumn('payment_method_id', 'payment_method');
            });
        }

        // Remove column from archive table
        if (Schema::hasColumn('archive', 'document_type_id')) {
            Schema::table('archive', function (Blueprint $table) {
                $table->dropForeign(['document_type_id']);
                $table->dropColumn('document_type_id');
            });
        }
    }
};
