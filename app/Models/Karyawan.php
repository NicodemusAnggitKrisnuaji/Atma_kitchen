<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_karyawan';

    protected $fillable = [
        'nama_karyawan',
        'alamat_karyawan',
        'tanggal_lahir',
        'honor_harian',
        'bonus_rajin',
    ];
}
