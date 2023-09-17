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
        Schema::create("partners", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("assignee_id")->nullable(); // id of the user responsible for this partner
            $table->string("number")->nullable(); // partner number (if applicable)
            $table->string("type")->nullable(); // customer, vendor, both customer and vendor
            $table->string("entity_type")->nullable(); // individual, company
            $table->string("name");
            $table->string("vat_number")->nullable();
            $table->string("language")->nullable();
            $table->text("notes")->nullable();
            $table->string("website")->nullable();
            $table->string("size")->nullable(); // small, medium, large
            $table->string("industry")->nullable(); // industry
            $table->string("status")->nullable(); // active, inactive, archived
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("partner_addresses", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->foreignUuid("partner_id")->nullable();
            $table->boolean("is_primary")->default(false);
            $table->string("type")->nullable(); // billing, shipping, mailing, office
            $table->string("address")->nullable();
            $table->string("city")->nullable();
            $table->string("zip_code")->nullable();
            $table->string("country")->nullable();
            $table->text("notes")->nullable();
            $table->timestamps();
        });

        Schema::create("partner_contacts", function (Blueprint $table) {
            $table->uuid("id")->primary();
            $table->uuid("partner_id")->nullable();
            $table->boolean("is_primary")->default(false);
            $table->string("name")->nullable();
            $table->string("function")->nullable();
            $table->string("email")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("mobile_number")->nullable();
            $table->string("fax_number")->nullable();
            $table->text("notes")->nullable();
            $table->timestamps();
        });

        // Migrate data from old tables (vendor and customer)
        $customers = DB::table("customers")->get();

        // Insert customers into partners table
        foreach ($customers as $customer) {
            DB::table("partners")->insert([
                "id" => $customer->id,
                "number" => Partner::getPartnerNumber(),
                "assignee_id" => null,
                "type" => "customer",
                "entity_type" => $customer->type,
                "name" => $customer->name,
                "vat_number" => $customer->vat_number,
                "language" => $customer->language,
                "notes" => $customer->notes,
                "website" => $customer->website,
                "status" => "active",
                "created_at" => $customer->created_at,
                "updated_at" => $customer->updated_at,
                "deleted_at" => $customer->deleted_at,
            ]);

            // Insert customer addresses into partner_addresses table
            $customer_addresses = DB::table("customer_addresses")
                ->where("customer_id", $customer->id)
                ->get();
            foreach ($customer_addresses as $customer_address) {
                DB::table("partner_addresses")->insert([
                    "id" => $customer_address->id,
                    "partner_id" => $customer_address->customer_id,
                    "type" => $customer_address->type,
                    "address" => $customer_address->address,
                    "city" => $customer_address->city,
                    "zip_code" => $customer_address->zip_code,
                    "country" => $customer_address->country,
                    "notes" => $customer_address->notes,
                    "created_at" => $customer_address->created_at,
                    "updated_at" => $customer_address->updated_at,
                ]);
            }

            // Insert customer contacts into partner_contacts table
            DB::table("partner_contacts")->insert([
                "id" => Str::uuid(),
                "partner_id" => $customer->id,
                "name" => $customer->name,
                "function" => null,
                "email" => $customer->email,
                "phone_number" => $customer->phone,
                "mobile_number" => null,
                "fax_number" => null,
                "notes" => null,
                "created_at" => $customer->created_at,
                "updated_at" => $customer->updated_at,
            ]);
            incrementLastItemNumber("partner");
        }

        // Get all vendors
        $vendors = DB::table("vendors")->get();
        // Insert vendors into partners table
        foreach ($vendors as $vendor) {
            DB::table("partners")->insert([
                "id" => $vendor->id,
                "assignee_id" => null,
                "number" => Partner::getPartnerNumber(), // partner number (if applicable)
                "type" => "vendor",
                "entity_type" => $vendor->type,
                "name" => $vendor->name,
                "vat_number" => $vendor->vat_number,
                "website" => $vendor->website,
                "status" => "active",
                "created_at" => $vendor->created_at,
                "updated_at" => $vendor->updated_at,
                "deleted_at" => $vendor->deleted_at,
            ]);

            // Insert vendor addresses into partner_addresses table
            DB::table("partner_addresses")->insert([
                "id" => Str::uuid(),
                "partner_id" => $vendor->id,
                "type" => "office",
                "address" => $vendor->address,
                "city" => $vendor->city,
                "zip_code" => $vendor->zip_code,
                "country" => $vendor->country,
                "created_at" => $vendor->created_at,
                "updated_at" => $vendor->updated_at,
            ]);

            // Insert vendor contacts into partner_contacts table
            DB::table("partner_contacts")->insert([
                "id" => Str::uuid(),
                "partner_id" => $vendor->id,
                "name" => $vendor->name,
                "function" => null,
                "email" => $vendor->email,
                "phone_number" => $vendor->phone,
                "mobile_number" => null,
                "fax_number" => null,
                "notes" => null,
                "created_at" => $vendor->created_at,
                "updated_at" => $vendor->updated_at,
            ]);
            incrementLastItemNumber("partner");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("partner_contacts");
        Schema::dropIfExists("partner_addresses");
        Schema::dropIfExists("partners");
    }
};
