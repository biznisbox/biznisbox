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
        Schema::dropIfExists('open_banking');
        Schema::create('open_banking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('bank_id')->nullable();
            $table->string('iban')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_logo')->nullable();
            $table
                ->boolean('payment_available')
                ->default(0)
                ->nullable();
            $table->string('account_id')->nullable();
            $table->string('agreement_id')->nullable();
            $table->string('agreement_status')->nullable();
            $table->string('requisition_id')->nullable();
            $table->string('requisition_status')->nullable();
            $table->timestamp('connection_valid_until')->nullable();
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
        Schema::dropIfExists('open_banking');
    }
};
