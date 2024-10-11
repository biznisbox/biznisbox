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
        Schema::create('partner_activities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('partner_id')->nullable()->references('id')->on('partners')->cascadeOnDelete();
            $table->foreignUuid('partner_contact_id')->nullable()->references('id')->on('partner_contacts')->cascadeOnDelete();
            $table->foreignUuid('employee_id')->nullable()->references('id')->on('employees')->cascadeOnDelete();
            $table->string('type')->nullable(); // call, email, meeting, etc.
            $table->string('subject')->nullable(); // subject of the activity
            $table->string('location')->nullable(); // location of the activity (e.g. Zoom link, physical address, etc.)
            $table->longText('content')->nullable(); // content of the activity
            $table->string('priority')->nullable(); // low, normal, high
            $table->dateTime('start_date')->nullable(); // start date and time
            $table->dateTime('end_date')->nullable(); // end date and time
            $table->string('duration')->nullable(); // duration of the activity
            $table->string('status')->nullable(); // planned, in progress, completed, canceled
            $table->string('outcome')->nullable(); // outcome of the activity (e.g. success, failure, etc.)
            $table->string('notes')->nullable(); // internal notes
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('partner_activities');
    }
};
