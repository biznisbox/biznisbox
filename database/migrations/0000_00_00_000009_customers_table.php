<?php

use Illuminate\Database\Eloquent\Scope;
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
        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table
                ->string('type')
                ->default('individual')
                ->nullable(); // individual or company
            $table->string('vat_number')->nullable();
            $table->string('language')->nullable();
            $table->text('notes')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('default_payment_method')->nullable();
            $table->string('payment_terms')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::dropIfExists('customer_addresses');
        Schema::create('customer_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('customer_id')
                ->nullable()
                ->references('id')
                ->on('customers')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('type')->default('billing'); // Billing or Shipping
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('notes')->nullable();
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
        Schema::disableForeignKeyConstraints('customers');
        Schema::disableForeignKeyConstraints('customer_addresses');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('customer_addresses');
    }
};
