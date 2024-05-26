<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tip extends Model
{
    use HasFactory;
    
    public $timestamps = false;
    protected $table = 'tips';
    protected $primaryKey = 'id_tip';
    protected $fillable = [
        'id_pemesanan',
        'total',
        'jumlah',
        'hasil_tip',
    ];

    public function pemesanan() {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan');
    }
}