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
        Schema::create('schedule_runs', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID
            $table->string('task'); // task name
            $table->string('status'); // pending, running, success, failed
            $table->text('output')->nullable(); // output of the task
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_runs');
    }
};
