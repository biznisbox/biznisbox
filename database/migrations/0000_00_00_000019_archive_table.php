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
        Schema::dropIfExists('archive');
        Schema::create('archive', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('category_id')
                ->nullable()
                ->references('id')
                ->on('categories')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->string('name');
            $table->string('description')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_size')->nullable();
            $table->string('file_mime')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_hash_sha256')->nullable();
            $table->string('file_hash_md5')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('archive');
    }
};
