<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'penggunaan_bahan_bakus';
    protected $primaryKey = 'id_penggunaanBahanBaku';
    public $timestamps = false;

    protected $fillable = [
        'id_bahanBaku',
        'id_pemesanan',
        'jumlah',
        'tanggal',
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(bahanBaku::class, 'id_bahanBaku');
    }
}