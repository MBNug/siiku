<?php

namespace Database\Seeders;

use App\Models\Strategi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StrategiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // $table->string('kode', 2)->primary();
        //     $table->string('nama');
        //     $table->timestamps();
        $strategis = [
            [
                'kode' => "01", 
                'nama' => "Meningkatkan Siklus dan Kualitas Penjaminan Mutu Akademik", 
            ],
            [
                'kode' => "02", 
                'nama' => "Meningkatkan Kompetensi Mahasiswa yang Relevan dengan Revolusi Industri 4.0", 
            ],
            [
                'kode' => "03", 
                'nama' => "Meningkatkan Reputasi Undip Skala Nasional dan Internasional", 
            ],
            [
                'kode' => "04", 
                'nama' => "Meningkatkan Kualitas Penelitian dan Publikasi Bereputasi", 
            ],
            [
                'kode' => "05", 
                'nama' => "Meningkatkan Pendanaan Penelitian dan Publikasi", 
            ],
            [
                'kode' => "06", 
                'nama' => "Meningkatkan Kualitas Riset dan Pengembangan (Pusat Unggulan Iptek / PUI dan Sains Tekno Park / STP)", 
            ],
        ];
        foreach($strategis as $key => $value){
            Strategi::create($value);
        }
    }
}
