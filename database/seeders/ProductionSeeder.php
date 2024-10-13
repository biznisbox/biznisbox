<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        #  if(checkIfRunAppInDocker() === false) { # there is a bug in the docker container that prevents the seeding of the world
        #      $this->call([WorldSeeder::class]);
        #  }
        $this->call([PermissionRoleSeeder::class, SettingSeeder::class]);
    }
}
