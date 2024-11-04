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
        Schema::create('contracts', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('partner_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table
                ->foreignUuid('partner_address_id')
                ->nullable()
                ->references('id')
                ->on('partner_addresses')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->foreignUuid('category_id')->nullable()->references('id')->on('categories')->nullOnDelete()->cascadeOnUpdate();
            $table->string('number')->nullable();
            $table->string('type')->nullable(); // contract, agreement, NDA, SLA, etc.
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('status')->nullable(); // draft, in review, signed, rejected, waiting for signature, expired
            $table->longText('content')->nullable(); // HTML content
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->integer('version')->nullable();
            $table->dateTime('signed_date')->nullable();
            $table->dateTime('date_for_signature')->nullable(); // deadline for signature
            $table->string('notes')->nullable(); // internal notes
            $table->string('sha256')->nullable(); // SHA256 hash of the content
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('contract_signers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('contract_id')->nullable()->references('id')->on('contracts')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table
                ->foreignUuid('signer_external_key_id')
                ->nullable()
                ->references('id')
                ->on('external_keys')
                ->nullOnDelete()
                ->cascadeOnUpdate();
            $table->boolean('custom_signer')->nullable()->default(false);
            $table->string('signer_name')->nullable(); // if selected user_id copy of data
            $table->string('signer_email')->nullable(); // if selected user_id copy of data
            $table->string('signer_phone')->nullable();
            $table->string('signer_notes')->nullable();
            $table->string('status')->nullable(); // signed, unsigned, rejected, waiting for signature
            $table->integer('sign_order')->nullable();
            $table->longText('signature')->nullable(); // base64 encoded signature
            $table->string('signature_ip')->nullable();
            $table->string('signature_user_agent')->nullable();
            $table->dateTime('signature_date_time')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract_signers');
        Schema::dropIfExists('contracts');
    }
};
