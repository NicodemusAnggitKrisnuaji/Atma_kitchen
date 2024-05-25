<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = Cart::where('id_user', $user->id)->get();

        return view('contentCustomer.Cart.index', compact('cartItems'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'id_produk' => 'required|exists:produk,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Produk::find($request->id_produk);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan');
        }

        $cartItem = new Cart();
        $cartItem->id_user = Auth::id();
        $cartItem->id_produk = $product->id;
        $cartItem->jumlah = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item keranjang tidak ditemukan');
        }

        $cartItem->jumlah = $request->quantity;
        $cartItem->save();

        return redirect()->back()->with('success', 'Jumlah produk dalam keranjang berhasil diperbarui');
    }

    public function destroy($id)
    {
        $cartItem = Cart::find($id);

        if (!$cartItem) {
            return redirect()->back()->with('error', 'Item keranjang tidak ditemukan');
        }

        $cartItem->delete();

        return redirect()->back()->with('success', 'Item keranjang berhasil dihapus');
    }
}


