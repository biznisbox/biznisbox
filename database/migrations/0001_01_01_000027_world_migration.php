<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists(config('world.migrations.countries.table_name'));
        Schema::create(config('world.migrations.countries.table_name'), function (Blueprint $table) {
            $table->id();
            $table->string('iso2', 2);
            $table->string('name');
            $table->tinyInteger('status')->default(1);

            foreach (config('world.migrations.countries.optional_fields') as $field => $value) {
                if ($value['required']) {
                    $table->string($field, $value['length'] ?? null);
                }
            }
        });

        Schema::dropIfExists(config('world.migrations.cities.table_name'));
        Schema::create(config('world.migrations.cities.table_name'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->foreignId('state_id');
            $table->string('name');

            foreach (config('world.migrations.cities.optional_fields') as $field => $value) {
                if ($value['required']) {
                    $table->string($field, $value['length'] ?? null);
                }
            }
        });

        Schema::dropIfExists(config('world.migrations.timezones.table_name'));
        Schema::create(config('world.migrations.timezones.table_name'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->string('name');
        });

        Schema::dropIfExists(config('world.migrations.states.table_name'));
        Schema::create(config('world.migrations.states.table_name'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->string('name');

            foreach (config('world.migrations.states.optional_fields') as $field => $value) {
                if ($value['required']) {
                    $table->string($field, $value['length'] ?? null)->nullable();
                }
            }
        });

        Schema::dropIfExists(config('world.migrations.currencies.table_name'));
        Schema::create(config('world.migrations.currencies.table_name'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('country_id');
            $table->string('name');
            $table->string('code');
            $table->tinyInteger('precision')->default(2);
            $table->string('symbol');
            $table->string('symbol_native');
            $table->tinyInteger('symbol_first')->default(1);
            $table->string('decimal_mark', 1)->default('.');
            $table->string('thousands_separator', 1)->default(',');
        });

        Schema::dropIfExists(config('world.migrations.languages.table_name'));
        Schema::create(config('world.migrations.languages.table_name'), function (Blueprint $table) {
            $table->id();
            $table->char('code', 2);
            $table->string('name');
            $table->string('name_native');
            $table->char('dir', 3);
        });

        // Fix for migration error
        // Insert into migration table to avoid error

        $data = [
            [
                'migration' => '2020_07_07_055656_create_countries_table.php',
                'batch' => 1,
            ],
            [
                'migration' => '2020_07_07_055725_create_cities_table.php',
                'batch' => 1,
            ],
            [
                'migration' => '2020_07_07_055746_create_timezones_table.php',
                'batch' => 1,
            ],
            [
                'migration' => '2021_10_19_071730_create_states_table.php',
                'batch' => 1,
            ],
            [
                'migration' => '2021_10_23_082414_create_currencies_table.php',
                'batch' => 1,
            ],
            [
                'migration' => '2022_01_22_034939_create_languages_table.php',
                'batch' => 1,
            ],
        ];

        DB::table('migrations')->insert($data);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(config('world.migrations.countries.table_name'));
        Schema::dropIfExists(config('world.migrations.cities.table_name'));
        Schema::dropIfExists(config('world.migrations.timezones.table_name'));
        Schema::dropIfExists(config('world.migrations.states.table_name'));
        Schema::dropIfExists(config('world.migrations.languages.table_name'));
        Schema::dropIfExists(config('world.migrations.currencies.table_name'));

        // Delete from migration table to avoid error
        DB::table('migrations')->where('migration', '2020_07_07_055656_create_countries_table.php')->delete();
        DB::table('migrations')->where('migration', '2020_07_07_055725_create_cities_table.php')->delete();
        DB::table('migrations')->where('migration', '2020_07_07_055746_create_timezones_table.php')->delete();
        DB::table('migrations')->where('migration', '2021_10_19_071730_create_states_table.php')->delete();
        DB::table('migrations')->where('migration', '2021_10_23_082414_create_currencies_table.php')->delete();
        DB::table('migrations')->where('migration', '2022_01_22_034939_create_languages_table.php')->delete();
    }
};
