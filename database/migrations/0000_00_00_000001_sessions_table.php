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
        Schema::dropIfExists('sessions');
        Schema::create('sessions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('user_id')
                ->constrained('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('token')->nullable();
            $table->string('ip')->nullable();
            $table->string('device_type')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('os')->nullable();
            $table->string('os_family')->nullable();
            $table->string('browser')->nullable();
            $table->string('location')->nullable();
            $table->string('country')->nullable();
            $table->string('country_code')->nullable();
            $table->string('region')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->json('client_data')->nullable();
            $table->json('ip_data')->nullable();
            $table->string('fingerprint')->nullable(); // Fingerprint is a hash of the user's browser and device information
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable();
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
        Schema::dropIfExists('sessions');
    }
};
