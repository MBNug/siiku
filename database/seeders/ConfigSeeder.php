<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $years = range(2000, 2100);

        foreach ($years as $year) {
            Config::create([
                'tahun' => $year,
                'status' => '0',
            ]);
        }
    }
}
