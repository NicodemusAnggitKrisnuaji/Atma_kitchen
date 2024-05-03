<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiKaryawan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_karyawan',
        'nama_karyawan',
        'honor_harian',
        'bonus_rajin',
    ];

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
