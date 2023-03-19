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
        Schema::dropIfExists('online_payment');
        Schema::create('online_payment', function ($table) {
            $table->uuid('id')->primary();
            $table->string('payment_method')->nullable(); // stripe, paypal, etc
            $table->string('payment_id')->nullable(); // stripe payment id, paypal payment id, etc
            $table->string('payment_status')->nullable(); // success, failed, pending, etc
            $table->text('payment_response')->nullable(); // response from payment gateway
            $table->string('key')->nullable();
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
        Schema::dropIfExists('online_payment');
    }
};
