<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class config extends Model
{
    use HasFactory;
    protected $primaryKey = 'tahun';
    protected $fillable =['tahun', 'status', 'statusterakhir', 'triwulanterakhir'];
}
