<?php

namespace Database\Seeders;

use App\Models\Setting;
use Doctrine\Inflector\Rules\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->call([WorldSeeder::class, PermissionRoleSeeder::class, SettingSeeder::class]);
    }
}
