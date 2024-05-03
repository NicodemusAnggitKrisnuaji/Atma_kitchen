<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PencatatanPengeluaran extends Model
{
    use HasFactory;
    
    public $timestamps = false;

    protected $primaryKey = 'id_pencatatan';
    protected $fillable = [
        'nama',
        'harga',
    ];

}
