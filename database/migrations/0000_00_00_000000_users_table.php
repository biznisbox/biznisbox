<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('users');
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table
                ->string('email')
                ->unique()
                ->index()
                ->nullable();
            $table->string('password')->nullable();
            $table->boolean('active')->default(true);
            $table->string('picture')->nullable();
            $table->string('role')->default('user');
            $table
                ->dateTime('last_login_at')
                ->nullable()
                ->default(null);
            $table->string('language')->default('en');
            $table->softDeletes();
            $table->timestamps();
        });

        // Create admin user
        User::create([
            'id' => '00000000-0000-0000-0000-000000000000',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@test.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'active' => true,
            'picture' => null,
            'role' => 'super_admin',
            'timezone' => 'UTC',
            'last_login_at' => null,
            'language' => 'en',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
