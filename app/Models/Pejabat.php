<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pejabat extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $fillable = ['kode', 'departemen', 'jabatan', 'nama', 'nip', 'tandatangan'];
}
