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
        Schema::create('send_email_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email_template')->nullable();
            $table->string('module')->nullable();
            $table->string('mail_to')->nullable();
            $table->string('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('status')->nullable();
            $table->string('triggered_by')->nullable();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });

        // Add system log table
        Schema::create('system_log', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('action')->nullable(); // e.g name of the function
            $table->string('module')->nullable();
            $table->text('message')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('type')->nullable(); // e.g., 'info', 'warning', 'error'
            $table->string('severity')->nullable(); // e.g., 'low', 'medium', 'high'
            $table->string('status')->nullable();
            $table->string('triggered_by')->nullable(); // e.g., 'system', 'user'
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->json('context')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('send_email_log');
        Schema::dropIfExists('system_log');
    }
};
