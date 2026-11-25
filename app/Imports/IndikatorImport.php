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
        $kodeRaw = isset($row[0]) ? trim((string) $row[0]) : '';
        $strategi = isset($row[1]) ? trim((string) $row[1]) : '';
        $indikator = isset($row[2]) ? trim((string) $row[2]) : '';
        if ($kodeRaw === '' || $indikator === '' || in_array(strtolower($kodeRaw), ['kode', 'no'], true)) {
            return null;
        }
        $tahun = DB::table('configs')->where('status', '=', '1')->first();
        if (!$tahun) {
            return null;
        }
        return new Indikator([
            'kode' => $kodeRaw . $tahun->tahun,
            'strategi' => $strategi !== '' ? $strategi : '-',
            'indikator_kinerja' => $indikator,
            'satuan' => isset($row[3]) ? trim((string) $row[3]) : '-',
            'keterangan' => isset($row[4]) ? trim((string) $row[4]) : null,
            'definisi' => isset($row[5]) ? trim((string) $row[5]) : '-',
            'cara_perhitungan' => isset($row[6]) ? trim((string) $row[6]) : '-',
        ]);
    }
}
