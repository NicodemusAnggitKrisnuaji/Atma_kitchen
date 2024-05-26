<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Hampers;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class DetailProdukController extends Controller
{
    public function detailCake()
    {
        $produk = Produk::get();

        return view('detailCake', compact('produk'));
    }

    public function detailRoti()
    {
        $produk = Produk::get();

        return view('detailRoti', compact('produk'));
    }

    public function detailMinuman()
    {
        $produk = Produk::get();

        return view('detailMinuman', compact('produk'));
    }

    public function detailTitipan()
    {
        $produk = Produk::get();

        return view('detailTitipan', compact('produk'));
    }

    public function detailHampers()
    {
        $produk = Produk::get();
        $hampers = Hampers::get();

        return view('detailHampers', compact('produk', 'hampers'));
    }
}