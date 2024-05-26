<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function showNota($id)
    {
        $pemesanan = Pemesanan::with('user', 'details.produk')->findOrFail($id);
        return view('nota', compact('pemesanan'));
    }
}
