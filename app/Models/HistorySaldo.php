<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySaldo extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_history';
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'saldo_ditarik',
        'status',
        'rekening',
        'tanggal_ditarik',
        'bank',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
