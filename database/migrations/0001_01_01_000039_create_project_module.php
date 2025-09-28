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
        Schema::create('projects', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('created_by')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->uuid('partner_id')->nullable()->references('id')->on('partners')->nullOnDelete()->cascadeOnUpdate();
            $table->string('project_key', 15)->nullable(); // short unique key (used in task numbers)
            $table->string('number')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->default('not_started');
            $table->string('priority')->default('medium');
            $table->decimal('budget', 15, 2)->nullable();
            $table->boolean('active')->default(true);
            $table->boolean('is_billable')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('project_members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->references('id')->on('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('user_id')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('role')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('project_id')->references('id')->on('projects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->uuid('assigned_to')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->uuid('created_by')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('number')->nullable();
            $table->string('title');
            $table->string('type')->nullable(); // milestone, task, bug, feature
            $table->string('category')->nullable(); // e.g., frontend, backend, documentation
            $table->text('notes')->nullable();
            $table->string('progress_in_percent')->default('0');
            $table->text('tags')->nullable(); // comma-separated tags
            $table->text('description')->nullable();
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->date('completed_at')->nullable();
            $table->string('status')->default('not_started');
            $table->string('priority')->default('medium');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('project_members');
        Schema::dropIfExists('projects');
    }
};
