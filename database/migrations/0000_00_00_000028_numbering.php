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
        // This table is used for numbering of the documents (invoices, offers, etc.) and other modules
        Schema::dropIfExists('numbering');
        Schema::create('numbering', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('year');
            $table->string('module'); // Module of the numbering - invoice, document, estimate, etc.
            $table->integer('number')->default(0); // Number of the document (invoice number, offer number, etc.)
        });

        Schema::table('products', function (Blueprint $table) {
            $table
                ->string('number')
                ->nullable()
                ->after('id');
        });

        Schema::table('customers', function (Blueprint $table) {
            $table
                ->string('number')
                ->nullable()
                ->after('id');
        });

        Schema::table('vendors', function (Blueprint $table) {
            $table
                ->string('number')
                ->nullable()
                ->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('numbering');
    }
};
