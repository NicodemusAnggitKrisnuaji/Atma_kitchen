<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_hampers extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'id_detail';


    protected $fillable = [
        'id_hampers',
        'id_produk',
        'id_bahanBaku',
        'jumlah',
    ];

    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function hampers() {
        return $this->belongsTo(Produk::class, 'id_hampers');
    }

    public function bahanBaku() {
        return $this->belongsTo(bahanBaku::class, 'id_bahanBaku');
    }

}
