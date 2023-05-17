<?php

namespace Database\Seeders;

use App\Models\Departemen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartemenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $departemens = [
            [
                'kode' => "01", 
                'nama' => "Matematika", 
            ],
            [
                'kode' => "02", 
                'nama' => "Biologi", 
            ],
            [
                'kode' => "03", 
                'nama' => "Kimia", 
            ],
            [
                'kode' => "04", 
                'nama' => "Fisika", 
            ],
            [
                'kode' => "05", 
                'nama' => "Statistika", 
            ],
            [
                'kode' => "06", 
                'nama' => "Informatika", 
            ],
        ];

        foreach($departemens as $key => $value){
            Departemen::create($value);
        }
    }
}
