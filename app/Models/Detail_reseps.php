<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Detail_reseps extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $primaryKey = 'id_detail';


    protected $fillable = [
        'id_resep',
        'id_bahanBaku',
        'jumlah',
    ];

    public function resep() {
        return $this->belongsTo(Resep::class, 'id_resep');
    }

    public function bahanBaku() {
        return $this->belongsTo(bahanBaku::class, 'id_bahanBaku');
    }

}
