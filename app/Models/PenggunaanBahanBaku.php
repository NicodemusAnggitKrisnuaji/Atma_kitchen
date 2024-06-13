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
    ];

    public function bahan_baku()
    {
        return $this->belongsTo(bahan_baku::class, 'id_bahanBaku');
    }
}
