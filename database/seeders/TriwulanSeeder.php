<?php

namespace Database\Seeders;

use App\Models\Triwulan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TriwulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $triwulans = [
            [
                'triwulan' => "0",  #akhir tahun
                'status' => "0",
                
            ],
            [
                'triwulan' => "1", 
                'status' => "0",
                
            ],
            [
                'triwulan' => "2", 
                'status' => "0",
                
            ],
            [
                'triwulan' => "3", 
                'status' => "0",
                
            ],
            [
                'triwulan' => "4", 
                'status' => "0",
                
            ],
        ];
        foreach($triwulans as $key => $value){
            Triwulan::create($value);
        }
    }
}
