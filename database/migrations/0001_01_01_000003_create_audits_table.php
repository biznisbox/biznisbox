<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        $table = config('audit.drivers.database.table', 'activity_log');
        Schema::create($table, function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_type')->nullable();
            $table->uuid('user_id')->nullable();
            $table->string('event')->nullable();
            $table->string('auditable_type')->nullable();
            $table->uuid('auditable_id')->nullable();
            $table->longText('old_values')->nullable();
            $table->longText('new_values')->nullable();
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 1023)->nullable();
            $table->string('tags')->nullable();
            $table->string('type')->nullable()->default('internal'); // type of activity log (internal, external) - default internal
            $table->string('external_key')->nullable(); // external key for external activity logs
            $table->timestamps();
            $table->index(['auditable_type', 'auditable_id', 'user_type', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $table = config('audit.drivers.database.table', 'activity_log');
        Schema::dropIfExists($table);
    }
}
