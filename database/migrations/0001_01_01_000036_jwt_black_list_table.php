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
        Schema::create('jwt_black_list', function (Blueprint $table) {
            $table->uuid('id')->primary(); // This is the id
            $table->string('key'); // This is the jti
            $table->timestamp('valid_until'); // This is the expiration date
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jwt_black_list');
    }
};
