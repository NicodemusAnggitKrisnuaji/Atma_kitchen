<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_user',
        'id_produk',
        'alamat',
        'tanggal_pesan',
        'tanggal_lunas',
        'tanggal_ambil',
        'jenis_pengiriman',
        'jumlah',
        'status',
        'total',
    ];

    protected $casts = [
        'id_pemesanan' => 'string',
    ];
    
    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
