<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pemesanan';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pemesanan',
        'id_user',
        'tanggal_pesan',
        'tanggal_lunas',
        'tanggal_ambil',
        'jenis_pengiriman',
        'status',
        'bukti',
        'total',
        'jarak',
        'total_jarak',
        'tip',
        'total_tip',
        'total_keseluruhan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
