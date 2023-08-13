<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisasiPTNBH extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $fillable =['kode','strategi', 'indikator_kinerja', 'satuan', 'keterangan', 'definisi', 'cara_perhitungan', 'target','nilai', 'bukti1', 'bukti2', 'bukti3', 'bukti4', 'bukti5', 'status', 'nilaireal'];
}
