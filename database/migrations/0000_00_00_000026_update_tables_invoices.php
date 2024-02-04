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
            $table
                ->foreignUuid('sales_person_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->nullOnDelete()
                ->cascadeOnUpdate()
                ->after('payer_id');
            $table->string('type')->nullable()->after('sales_person_id');
            $table->string('default_currency')->nullable()->after('status');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table
                ->foreignUuid('sales_person_id')
                ->nullable()
                ->references('id')
                ->on('employees')
                ->nullOnDelete()
                ->cascadeOnUpdate()
                ->after('payer_id');
            $table->string('type')->nullable()->after('sales_person_id');
            $table->string('default_currency')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('sales_person_id');
            $table->dropColumn('type');
            $table->dropColumn('default_currency');
        });

        Schema::table('quotes', function (Blueprint $table) {
            $table->dropColumn('sales_person_id');
            $table->dropColumn('type');
            $table->dropColumn('default_currency');
        });
    }
};
