<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Hampers;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class CatalogController extends Controller
{
    public function index()
    {
        $produk = Produk::get();
        $hampers = Hampers::get();

        return view('catalog', compact('produk', 'hampers'));

    }
}
