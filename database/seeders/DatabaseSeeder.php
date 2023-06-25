<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(UserData::class);
        $this->call(DepartemenSeeder::class);
        $this->call(StrategiSeeder::class);
        // $this->call(IndikatorSeeder::class);
        $this->call(TargetSeeder::class);
        $this->call(ConfigSeeder::class);
    }
}
