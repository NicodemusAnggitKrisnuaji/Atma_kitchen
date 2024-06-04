<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Pemesanan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $carts = Pemesanan::where('id_user', $user->id)->get();

        // Muat relasi produk bersama dengan item keranjang
        $cartItems = Cart::whereIn('id_pemesanan', $carts->pluck('id_pemesanan'))
            ->with('produk') // Muat relasi produk
            ->get();

        return view('contentCustomer.Cart.index', compact('cartItems'));
    }

    public function tampilkanPesananBelumDibayar()
    {
        $user = Auth::user();
        $Pemesanans = Pemesanan::where('status', 'belum dibayar')->where('id_user', $user->id)->get();

        $cart = [];
        foreach ($Pemesanans as $pemesanan) {
            $carts = Cart::where('id_pemesanan', $pemesanan->id_pemesanan)->get();
            foreach ($carts as $cartItem) {
                if ($cartItem->id_produk !== null) {
                    $cart[] = $cartItem->produk->nama_produk;
                }

                if ($cartItem->id_hampers !== null) {
                    $cart[] = $cartItem->hampers->nama_hampers;
                }
            }
        }

        return view('contentCustomer.Cart.payment', compact('Pemesanans', 'cart'));
    }

    public function kirimBuktiPembayaran($id, Request $request)
    {
        $Pemesanan = Pemesanan::findOrFail($id);


        $validate = Validator::make($request->all(), [
            'bukti' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }


        if ($request->hasFile('bukti')) {
            $image = $request->file('bukti');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('buktiPembayaran'), $imageName);
            $Pemesanan->bukti = $imageName;
        }


        $Pemesanan->status = 'sudah dibayar';
        $Pemesanan->save();

        return redirect()->route('pembayaran')->with('success', 'Bukti pembayaran berhasil dikirim. Menunggu konfirmasi.');
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

        $jumlah = $cartItem->jumlah;

        $cartItem->delete();

        $produk = Produk::find($cartItem->id_produk);
        $produk->stock += $jumlah;
        $produk->save();

        return redirect()->back()->with('success', 'Item keranjang berhasil dihapus');
    }
}
