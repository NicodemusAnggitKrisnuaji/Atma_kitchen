<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_penitip',
        'nama_produk',
        'harga_produk',
        'stock',
        'deskripsi_produk',
        'kategori',
        'image'
    ];

    public function penitip()
    {
        return $this->belongsTo(Penitip::class, 'id_penitip');
    }
}
    