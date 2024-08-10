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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->unique()->index()->nullable();
            $table->string('password')->nullable(); // Null for oauth users
            $table->boolean('active')->default(true);
            $table->string('picture')->nullable();
            $table->dateTime('last_login_at')->nullable()->default(null);
            $table->string('language')->default('en');
            $table->string('timezone')->default('UTC'); // UTC, Europe/Paris, ...
            $table->string('theme')->default('light'); // light, dark -> for frontend
            $table->string('oauth_user')->nullable(); // true if user is oauth user
            $table->boolean('two_factor_auth')->default(false);
            $table->string('type')->nullable()->default('user'); // user, admin, employee, bot, ...
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
