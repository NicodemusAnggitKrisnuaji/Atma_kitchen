<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_cart';
    public $timestamps = false;
    protected $fillable = [
        'id_cart',
        'id_produk',
        'id_pemesanan',
        'id_hampers',
        'jumlah',
        'harga',
    ];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function hampers()
    {
        return $this->belongsTo(Hampers::class, 'id_hampers');
    }
}
