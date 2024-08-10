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
        Schema::create('archive', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate(); // user_id is the user that created the document
            $table->foreignUuid('folder_id')->nullable()->references('id')->on('categories')->nullOnDelete()->cascadeOnUpdate(); // category_id is the folder that the document is in
            $table->foreignUuid('partner_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate(); // partner_id is the partner that the document is related to
            $table->foreignUuid('storage_location_id')->nullable()->references('id')->on('departments')->nullOnDelete()->cascadeOnUpdate(); // storage_location_id is the department that the document is stored in
            $table->uuid('connected_document_id')->nullable(); // connected_document_id is the document that this document is related to (e.g. invoice, receipt, etc.)
            $table->string('connected_document_type')->nullable(); // connected_document_type is the type of document that this document is related to (e.g. invoice, receipt, etc.)
            $table->string('number')->nullable(); // document number (DOC-0001)
            $table->string('name'); // document name (visible name)
            $table->string('type')->nullable(); // document type (invoice, receipt, etc.)
            $table->string('description')->nullable(); // document description
            $table->string('file_name')->nullable(); // file name - original file name
            $table->string('file_size')->nullable(); // file size in bytes
            $table->string('file_mime')->nullable(); // file mime type
            $table->string('file_path')->nullable(); // file path
            $table->string('file_hash_sha256')->nullable(); // file hash sha256
            $table->string('file_hash_md5')->nullable(); // file hash md5
            $table->string('file_extension')->nullable(); // file extension
            $table->string('status')->nullable()->default('active'); // active, inactive, archived
            $table->string('visibility')->nullable()->default('private'); // private, public
            $table->string('protection_level')->nullable()->default('internal'); // public, private, internal, confidential, secret, top_secret
            $table->date('archived_until')->nullable(); // date until the document is archived
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive');
    }
};
