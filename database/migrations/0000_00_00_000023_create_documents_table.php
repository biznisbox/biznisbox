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
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->uuid('document_category_id')
                ->nullable()
                ->references('id')
                ->on('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate(); // document_category_id is the folder that the document is in
            $table
                ->foreignUuid('partner_id')
                ->nullable()
                ->references('id')
                ->on('partners')
                ->nullOnDelete()
                ->cascadeOnUpdate(); // partner_id is the partner that the document is related to
            $table->string('number')->nullable(); // Number of the document (invoice number, offer number, etc.)
            $table->string('name'); // Name of the document - title of the document
            $table->date('date')->nullable(); // Date of the document
            $table->date('due_date')->nullable(); // Due date of the document
            $table->string('access')->default('public'); // Access of the document - public, private, internal
            $table->string('status')->default('draft'); // Status of the document - draft, published, archived
            $table->string('type')->default('document'); // Type of the document - offer, document, report
            $table->string('version')->default('1.0'); // Version of the document
            $table->longText('content')->nullable(); // Content of the document - html
            $table->boolean('archived')->default(false); // If the document is archived or not
            $table->string('archive_name')->nullable(); // Name of the archive (if the document is archived)
            $table->string('archive_path')->nullable(); // Path of the archive (if the document is archived)
            $table->string('notes')->nullable(); // Notes of the document (internal notes)
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
