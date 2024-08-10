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
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('assignee_id')->nullable(); // id of the user responsible for this partner
            $table->string('number')->nullable(); // partner number or code
            $table->string('type')->nullable(); // customer, supplier, employee, other
            $table->string('entity_type')->nullable(); // individual, company, other
            $table->string('name');
            $table->string('vat_number')->nullable();
            $table->string('language')->nullable(); // language
            $table->text('notes')->nullable();
            $table->string('website')->nullable();
            $table->string('size')->nullable(); // small, medium, large
            $table->string('industry')->nullable(); // industry
            $table->string('currency')->nullable(); // currency
            $table->string('status')->nullable(); // active, inactive, archived
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('partner_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('partner_id')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('type')->nullable(); // billing, shipping, mailing, office
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('partner_contacts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('partner_id')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->string('name')->nullable();
            $table->string('function')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('fax_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_addresses');
        Schema::dropIfExists('partner_contacts');
        Schema::dropIfExists('partners');
    }
};
