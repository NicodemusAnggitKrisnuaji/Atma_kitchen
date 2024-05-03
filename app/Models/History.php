<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nama_produk',
        'tanggal',
        'harga',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
