<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode';
    protected $fillable =['kode', 'strategi', 'indikator_kinerja', 'satuan', 'keterangan', 'definisi', 'cara_perhitungan'];
}
