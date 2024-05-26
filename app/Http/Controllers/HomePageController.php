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

    public function productview($id)
    {

        $produk = Produk::find($id);
        return view('productview', compact('produk'));

    }
}
