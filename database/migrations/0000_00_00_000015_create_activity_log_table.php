<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('activity_log');
        Schema::create('activity_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->uuid('user_id')->nullable();
            $table->string('user_type')->nullable();
            $table->text('event')->nullable();
            $table->uuid('auditable_id')->nullable();
            $table->string('auditable_type');
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->text('user_agent', 1023)->nullable();
            $table->text('tags')->nullable();
            $table->string('type')->nullable(); // type of activity log (internal, external) - default internal
            $table->string('external_key')->nullable(); // external key for external activity log
            $table->timestamps();
            $table->index(['user_id', 'user_type', 'auditable_id', 'auditable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};
