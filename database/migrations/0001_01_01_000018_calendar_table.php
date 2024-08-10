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
        Schema::create('calendar_events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('title');
            $table->string('icon')->nullable();
            $table->string('type')->default('event'); // event or task
            $table->string('color')->default('#000000')->nullable();
            $table->longText('description')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
            $table->string('timezone')->default('UTC');
            $table->boolean('all_day')->default(false);
            $table->text('rrule')->nullable(); // Recurrence Rule
            $table->string('location')->nullable();
            $table->string('reminder')->nullable();
            $table->string('show_as')->default('busy')->nullable(); // busy or free or tentative or outofoffice
            $table->string('status')->default('confirmed')->nullable(); // confirmed or tentative or cancelled
            $table->string('privacy')->default('public')->nullable(); // public or private or confidential
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('calendar_event_attendees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_id')->references('id')->on('calendar_events')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('email')->nullable();
            $table->string('name')->nullable();
            $table->string('status')->default('needs_action')->nullable();
            $table->string('role')->default('attendee')->nullable();
            $table->string('participation_status')->default('needs_action')->nullable();
            $table->string('rsvp_response')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendar_event_attendees');
        Schema::dropIfExists('calendar_events');
    }
};
