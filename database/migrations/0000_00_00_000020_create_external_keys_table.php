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
        Schema::dropIfExists('external_keys');
        Schema::create('external_keys', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('module'); // module name - invoice, estimate, payment, etc.
            $table->uuid('module_item_id'); // module id - invoice id, estimate id, payment id, etc.
            $table->string('key'); // external key used in URL
            $table->string('creation_method')->nullable(); // send_email, manual, via_api, etc.
            $table->string('created_by')->nullable(); // user id  - user who created the external key
            $table->timestamp('expires_at')->nullable(); // when the key expires - null means never expires
            $table->tinyInteger('used')->default(0); // 0 - not used, 1 - used
            $table->timestamp('used_at')->nullable(); // when the key was used - null means not used
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
        Schema::dropIfExists('external_keys');
    }
};
