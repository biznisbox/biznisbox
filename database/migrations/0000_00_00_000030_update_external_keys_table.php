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
        Schema::table('external_keys', function (Blueprint $table) {
            $table->string('recipient')->nullable()->after('key'); // The recipient of the key (e.g. email address)
            $table->string('recipient_type')->nullable()->after('recipient'); // The type of recipient (e.g. email)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('external_keys', function (Blueprint $table) {
            $table->dropColumn('recipient');
            $table->dropColumn('recipient_type');
        });
    }
};
