<?php

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
        Schema::dropIfExists('documents');
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID is a unique identifier for each document
            $table
                ->foreignUuid('created_by')
                ->nullable()
                ->references('id')
                ->on('users')
                ->nullOnDelete()
                ->cascadeOnUpdate(); // The user who created the document
            $table->string('name'); // Name of the document (e.g. "Invoice 2020-01-01")
            $table->string('description')->nullable(); // Description of the document
            $table->string('file_name')->nullable(); // The filesystem name of the document (randomly generated)
            $table->string('file_type')->nullable(); // The file type of the document (e.g. "pdf")
            $table->string('file_size')->nullable(); // The file size of the document (e.g. "1.2MB")
            $table->string('file_path')->nullable(); // The path to the document on the filesystem eg. "documents/2020/01/01/1234567890.pdf"
            $table->string('file_hash_sha256')->nullable(); // sha256 hash of the file (used to check if the file has changed)
            $table->string('file_hash_md5')->nullable(); // md5 hash of the file (for compatibility with older systems)
            $table->string('version')->default(1); // The version of the document (e.g. "1")
            $table->softDeletes(); // Soft delete the document
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
};
