<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Produk;
use App\Models\Pemesanan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = Pemesanan::where('id_user', $user->id)->get();

        $pemesanan = Pemesanan::with('user', 'details.produk')->findOrFail($id);

        return view('contentCustomer.Cart.payment', compact('pemesanan', 'cart'));
    }
}
