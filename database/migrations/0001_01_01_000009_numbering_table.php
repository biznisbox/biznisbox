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
        Schema::create('numbering', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->string('module'); // Module of the numbering - invoice, document, estimate, etc.
            $table->integer('number')->default(0); // Number of the document (invoice number, offer number, etc.)
            $table->string('pattern')->nullable(); // Pattern of the numbering (for example: INV-YYYY-0000)
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
