<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $activeYear = max(2000, min(2100, (int) date('Y')));
        $priorYear = max(2000, $activeYear - 1);
        $now = now();
        $rows = [];

        foreach (range(2000, 2100) as $year) {
            $isActive = ($year === $activeYear);
            $isPrior = ($year === $priorYear);

            $rows[] = [
                'tahun' => $year,
                'status' => $isActive ? '1' : '0',
                'statusterakhir' => $isActive ? '1' : ($isPrior ? '2' : '0'),
                'triwulanterakhir' => $isActive ? '2' : '0',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($rows, 100) as $chunk) {
            DB::table('configs')->insert($chunk);
        }
    }
}
