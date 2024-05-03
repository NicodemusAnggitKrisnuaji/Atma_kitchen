<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penitip extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_penitip';


    protected $fillable = [
        'nama',
        'nomor_telepon',
        'alamat',
        'komisi',
    ];

}
