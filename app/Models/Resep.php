<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $primaryKey = 'id_resep';
    protected $fillable = [
        'id_produk',
        'nama_resep',
        'prosedur',
    ];

    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }
}
