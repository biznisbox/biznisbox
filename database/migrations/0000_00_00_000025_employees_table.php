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
        Schema::dropIfExists('employees');
        Schema::create('employees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('department_id')->nullable()->references('id')->on('departments')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignUuid('user_id')->nullable()->references('id')->on('users')->nullOnDelete()->cascadeOnUpdate();
            $table->string('number')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->longText('description')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->string('position')->nullable(); // Position in the company
            $table->string('type')->nullable(); // Type of the employee - full time, part time, etc.
            $table->string('salary')->nullable(); // Salary of the employee
            $table->string('hourly_rate')->nullable(); // Hourly rate of the employee
            $table->string('level')->nullable(); // Level of the employee - junior, senior, etc.
            $table->string('contract_type')->nullable(); // Contract type of the employee - permanent, temporary, etc.
            $table->string('contract_start_date')->nullable(); // Contract start date
            $table->string('contract_end_date')->nullable(); // Contract end date
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
