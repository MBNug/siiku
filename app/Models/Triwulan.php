<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Triwulan extends Model
{
    use HasFactory;
    protected $primaryKey = 'triwulan';
    public $incrementing = false;
    protected $fillable =['triwulan', 'status'];
}
