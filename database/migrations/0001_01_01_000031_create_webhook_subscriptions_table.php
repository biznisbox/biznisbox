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
        Schema::create('webhook_subscriptions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete();
            $table->string('name')->nullable();
            $table->string('url')->unique(); // The URL to which the webhook will be sent
            $table->string('signature_secret_key')->nullable(); // The secret key used to sign the webhook
            $table->string('http_verb')->default('post');
            $table->text('headers')->default('[{"key": "Content-Type", "value": "application/json", "default": true}]');
            $table->boolean('is_active')->default(true);
            $table->boolean('can_be_edited')->default(true);
            $table->text('listen_events')->default('["*"]'); // The events to which the webhook will listen
            $table->text('notes')->nullable();
            $table->timestamp('last_called_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('webhook_subscriptions');
    }
};
