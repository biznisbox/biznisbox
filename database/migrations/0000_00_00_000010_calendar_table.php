<?php

use GuzzleHttp\Promise\Create;
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
        Schema::dropIfExists('calendar_events');
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table
                ->foreignUuid('user_id')
                ->nullable()
                ->references('id')
                ->on('users')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('type')->default('event'); // event or task
            $table
                ->string('color')
                ->default('#000000')
                ->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('timezone')->default('UTC');
            $table->boolean('all_day')->default(false);
            $table->string('rrule')->nullable();
            $table->string('location')->nullable();
            $table->string('reminder')->nullable();
            $table
                ->string('show_as')
                ->default('busy')
                ->nullable(); // busy or free or tentative or outofoffice
            $table
                ->string('status')
                ->default('confirmed')
                ->nullable(); // confirmed or tentative or cancelled
            $table
                ->string('privacy')
                ->default('public')
                ->nullable(); // public or private or confidential
            $table->softDeletes();
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
        Schema::disableForeignKeyConstraints('calendar_events');
        Schema::dropIfExists('calendar_events');
    }
};
