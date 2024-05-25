<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_produk',
        'quantity',
    ];

    public function produk() {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
}
