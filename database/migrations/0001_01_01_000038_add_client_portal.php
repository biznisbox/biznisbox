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
        // Add column for client portal
        Schema::table('partner_contacts', function (Blueprint $table) {
            $table->boolean('client_portal')->default(0)->after('is_primary');
            $table
                ->foreignUuid('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->after('partner_id')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove column for client portal
        Schema::table('partner_contacts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('client_portal');
            $table->dropColumn('user_id');
        });
    }
};
