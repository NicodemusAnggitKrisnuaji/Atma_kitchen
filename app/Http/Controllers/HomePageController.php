<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Hampers;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index()
    {
        $produk = Produk::get();
        $hampers = Hampers::get();

        return view('homePage', compact('produk', 'hampers'));

    }
    public function homeCustomer()
    {
        $produk = Produk::get();
        $hampers = Hampers::get();

        return view('homePage', compact('produk', 'hampers'));

    }

    // public function liatProduk($id)
    // {
    //     $produk = Produk::find($id);

    //     return view('contentCustomer.liatMobil', compact('produk'));
    // }

    // public function liatHampers($id)
    // {
    //     $mobil = Mobil::find($id);

    //     return view('contentCustomer.liatMobil', compact('mobil'));
    // }


    // public function getData($id)
    // {

    //     if (Auth::check()) {
    //         $user = Auth::user()->id;
    //         $userLogin = User::find($user);

    //         $mobil = Mobil::find($id);

    //         return view('contentCustomer.pemesanan', compact('userLogin', 'mobil'));
    //     }
    // }

    // public function destroy($id)
    // {
    //     $transaksi = Transaksi::find($id);

    //     if ($transaksi) {
    //         $mobil = $transaksi->mobil;

    //         $mobil->stok += 1;
    //         $mobil->save();
    //         $transaksi->delete();
    //     }

    //     return redirect('home');
    // }

    // public function trackMobil()
    // {
    //     $transaksi = Transaksi::latest()->get();

    //     return view('contentCustomer.trackMobil', compact('transaksi'));
    // }
}
