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
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('current_balance');
            $table->date('date_opened')->nullable()->after('opening_balance'); // date account was opened (e.g. 2020-01-01)
            $table->date('date_closed')->nullable()->after('date_opened'); // date account was closed if applicable (e.g. 2020-01-01)
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->string('bank_transaction_id')->nullable()->after('id'); // bank transaction id (e.g. 1234567890)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->double('current_balance', 10, 2)->nullable()->default(0)->after('opening_balance');
            $table->dropColumn('date_opened');
            $table->dropColumn('date_closed');
        });

        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('bank_transaction_id');
        });
    }
};
