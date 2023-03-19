<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('units');
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('symbol');
            $table->timestamps();
        });

        DB::table('units')->insert([
            ['name' => 'Kilogram', 'symbol' => 'kg'],
            ['name' => 'Gram', 'symbol' => 'g'],
            ['name' => 'Liter', 'symbol' => 'l'],
            ['name' => 'Mililiter', 'symbol' => 'ml'],
            ['name' => 'Piece', 'symbol' => 'pcs'],
            ['name' => 'Box', 'symbol' => 'box'],
            ['name' => 'Pallet', 'symbol' => 'plt'],
            ['name' => 'Hour', 'symbol' => 'h'],
            ['name' => 'Minute', 'symbol' => 'm'],
            ['name' => 'Second', 'symbol' => 's'],
            ['name' => 'Day', 'symbol' => 'd'],
            ['name' => 'Week', 'symbol' => 'w'],
            ['name' => 'Month', 'symbol' => 'm'],
            ['name' => 'Year', 'symbol' => 'y'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('units');
    }
};
