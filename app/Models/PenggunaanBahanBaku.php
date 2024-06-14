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
        'tanggal_penggunaan',
        'jumlah',
    ];

    public function bahan_baku()
    {
        return $this->belongsTo(bahanBaku::class, 'id_bahanBaku');
    }
}