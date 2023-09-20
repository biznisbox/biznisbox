<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Partner;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('partners', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('assignee_id')->nullable(); // id of the user responsible for this partner
            $table->string('number')->nullable(); // partner number (if applicable)
            $table->string('type')->nullable(); // customer, vendor, both customer and vendor
            $table->string('entity_type')->nullable(); // individual, company
            $table->string('name');
            $table->string('vat_number')->nullable();
            $table->string('language')->nullable();
            $table->text('notes')->nullable();
            $table->string('website')->nullable();
            $table->string('size')->nullable(); // small, medium, large
            $table->string('industry')->nullable(); // industry
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
        Schema::dropIfExists('partner_contacts');
        Schema::dropIfExists('partner_addresses');
        Schema::dropIfExists('partners');
    }
};
