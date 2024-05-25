<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Support\Facades\Auth;

class DetailMinumanController extends Controller
{
    public function index()
    {
        $produk = Produk::get();

        return view('detailMinuman', compact('produk'));
    }
}
