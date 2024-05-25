<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'pengirimans';

    protected $primaryKey = 'id_pengiriman';

    protected $fillable = [
        'id_pemesanan',
        'jarak',
        'total',
    ];

    public function pemesanan() {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }
}
