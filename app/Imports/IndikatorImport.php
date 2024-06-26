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
        return new Indikator([
            //
            'kode' => $row[0].$tahun->tahun, 
            'strategi' => $row[1], 
            'indikator_kinerja' => $row[2], 
            'satuan' => $row[3],
            'keterangan' => $row[4], 
            'definisi' => $row[5], 
            'cara_perhitungan' => $row[6],
        ]);
    }
}
