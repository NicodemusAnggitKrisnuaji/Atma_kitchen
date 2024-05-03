<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hampers extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'id_hampers';


    protected $fillable = [
        'nama_hampers',
        'harga',
        'deskripsi',
        'isi',
        'stock',
        'image',
    ];
}
