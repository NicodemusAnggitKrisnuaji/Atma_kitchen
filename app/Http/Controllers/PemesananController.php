<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PemesananController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index()
    {
        $pemesanan = Pemesanan::latest()->paginate(5);

        return view('pemesanan.index', compact('details', 'id_hampers'));
    }
}
