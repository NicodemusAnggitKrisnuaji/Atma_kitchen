<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    // Menampilkan daftar pesanan yang perlu dibayar untuk pengguna yang sedang login
    public function tampilkanPesananBelumDibayar()
    {
        $user = Auth::user();
        $pemesanans = Pemesanan::where('id_user', $user->id)
            ->where('status', 'belum dibayar')
            ->get();
            
        return view('customer.index', compact('pemesanans'));
    }

    // Mengirim bukti pembayaran
    
}
