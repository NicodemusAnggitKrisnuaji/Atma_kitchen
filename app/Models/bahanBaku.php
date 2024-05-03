<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bahanBaku extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'id_bahanBaku';


    protected $fillable = [
        'nama',
        'satuan',
        'stock',
    ];

}
