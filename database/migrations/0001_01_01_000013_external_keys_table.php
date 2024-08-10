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
        Schema::create('external_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('module'); // module name - invoice, estimate, payment, etc.
            $table->uuid('module_item_id'); // module id
            $table->uuid('created_by')->nullable();
            $table->string('key'); // external key used in URL
            $table->string('creation_method')->nullable(); // send_email, manual, via_api, etc.
            $table->timestamp('expires_at')->nullable(); // when the key expires - null means never expires
            $table->boolean('used')->default(0); // 0 - not used, 1 - used
            $table->timestamp('used_at')->nullable(); // when the key was used - null means not used
            $table->string('recipient_type')->nullable(); // user, email, etc.
            $table->string('recipient_id')->nullable(); // user id or email or any other identifier
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_keys');
    }
};
