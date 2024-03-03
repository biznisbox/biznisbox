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
        Schema::dropIfExists('support_tickets');
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('assignee_id')->nullable()->references('id')->on('employees')->nullOnDelete()->cascadeOnUpdate(); // Employee who is assigned to the ticket
            $table->foreignUuid('partner_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate(); // Partner who created the ticket (if any)
            $table->foreignUuid('category_id')->nullable()->references('id')->on('categories')->nullOnDelete()->cascadeOnUpdate(); // Category of the ticket (if any)
            $table->foreignUuid('department_id')->nullable()->references('id')->on('departments')->nullOnDelete()->cascadeOnUpdate(); // Department of the ticket (if any) - sales, support, billing, etc.
            $table->string('number')->nullable(); // Number of the ticket - auto generated
            $table->string('subject'); // Subject of the ticket
            $table->string('status')->default('open'); // Status of the ticket - open, closed, archived, spam
            $table->string('priority')->default('low'); // Priority of the ticket - low, medium, high, urgent, critical
            $table->string('type')->default('ticket'); // Type of the ticket - ticket, question, problem, task
            $table->string('source')->default('email'); // Source of the ticket - email, phone, chat, web, social
            $table->longText('notes')->nullable(); // Notes of the ticket (internal notes) - html
            $table->text('tags')->nullable(); // Tags of the ticket (internal tags)
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::dropIfExists('support_ticket_content');
        Schema::create('support_ticket_content', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('ticket_id')->nullable()->references('id')->on('support_tickets')->nullOnDelete()->cascadeOnUpdate();
            $table->string('to')->nullable(); // To of the content - email or phone number or chat id
            $table->string('from')->nullable(); // From of the content - email or phone number or chat id
            $table->string('status')->default('draft'); // Status of the content - draft, sent, received, viewed
            $table->string('type')->default('message'); // Type of the content - message, note, attachment (file)
            $table->longText('message')->nullable(); // Content of the content - html
            $table->string('subject')->nullable(); // Subject of the content
            $table->string('message_id')->nullable(); // Message id of the content - email or chat id
            // Attachment
            $table->string('attachment_name')->nullable(); // Name of the attachment
            $table->string('attachment_path')->nullable(); // Path of the attachment
            $table->string('attachment_type')->nullable(); // Type of the attachment - image, video, audio, fil
            $table->string('attachment_size')->nullable(); // Size of the attachment
            $table->string('attachment_extension')->nullable(); // Extension of the attachment
            $table->string('attachment_mime')->nullable(); // Mime of the attachment
            $table->string('attachment_url')->nullable(); // Url of the attachment
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints(['support_tickets', 'support_ticket_content']);
        Schema::dropIfExists('support_tickets');
        Schema::dropIfExists('support_ticket_content');
    }
};
