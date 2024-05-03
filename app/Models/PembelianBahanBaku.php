<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBahanBaku extends Model
{
    use HasFactory;

    
    public $timestamps = false;

    protected $primaryKey = 'id_pembelian';

    protected $fillable = [
        'id_bahanBaku',
        'tanggal_pembelian',
        'jumlah',
        'total_harga'
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class, 'id_bahanBaku');
    }
}
