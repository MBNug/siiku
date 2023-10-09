<?php

namespace App\Imports;

use App\Models\Indikator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;

class IndikatorImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tahun = DB::table('configs') -> where('status', '=', '1') -> first();
        $kode = $row[0].$tahun->tahun;
        $strategi = $row[1];
        $indikator_kinerja = $row[2];
        $satuan = $row[3];
        $keterangan = $row[4];
        $definisi = $row[5];
        $cara_perhitungan = $row[6];
        if($row[0] == null){
            $kode = '9'.random_int(0,99).$tahun->tahun;
        }
        else{
            $kode = $row[0].$tahun->tahun;
        }
        if($row[1] == null){
            $strategi = '-';
        }
        elseif($row[2] == null){
            $indikator_kinerja = '-';
        }
        elseif($row[3] == null){
            $satuan = '-';
        }
        elseif($row[5] == null){
            $definisi = '-';
        }
        elseif($row[6] == null){
            $cara_perhitungan = '-';
        }
        return new Indikator([
            //
            'kode' => $kode, 
            'strategi' => $strategi, 
            'indikator_kinerja' => $indikator_kinerja, 
            'satuan' => $satuan,
            'keterangan' => $keterangan, 
            'definisi' => $definisi, 
            'cara_perhitungan' => $cara_perhitungan,
        ]);
    }
}
