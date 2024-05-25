<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Hampers;
use Illuminate\Http\Request;

class PemesananController extends Controller
{
    public function show($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            abort(404, 'Produk Tidak Ditemukan');
        }

        return view('pemesanan', compact('produk'));
    }

    public function createOrder(Request $request)
    {
        $user_id = Auth::id();

        // Ambil pemesanan terakhir pengguna jika ada
        $last_order = Pemesanan::where('id_user', $user_id)->latest()->first();

        if ($last_order) {
            $order = new Pemesanan();
            // Buat pemesanan baru jika tanggal pesan berbeda
            if ($order->id_pemesanan !== $last_order->id_pemesanan) {
                $order->id_user = $user_id;
                $order->tanggal_pesan = Carbon::now();
                $order->tanggal_lunas = null;
                $order->tanggal_kirim = Carbon::now()->addDays(3);
                $order->jenis_pengiriman = null;
                $order->status = 'belum dibayar';
                $order->bukti = null;
                $order->save();
            } else {
                $order = $last_order;
            }
        } else {
            // Buat pemesanan baru jika tidak ada pemesanan sebelumnya
            $order = new Pemesanan();
            $order->id_user = $user_id;
            $order->tanggal_pesan = Carbon::now();
            $order->tanggal_lunas = null;
            $order->tanggal_kirim = Carbon::now()->addDays(3);
            $order->jenis_pengiriman = null;
            $order->status = 'belum dibayar';
            $order->bukti = null;
            $order->save();
        }

        Cart::create([
            'jumlah' => $request->jumlah,
            'id_produk' => $request->id_produk ?? null,
            'id_pemesanan' => $order->id_pemesanan,
            'id_hampers' => $order->id_hampers ?? null,
            'harga' => $request->harga
        ]);

        $cart_items = Cart::where('id_user', $user_id)->get();
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item->jumlah * $item->produk->harga; // Asumsikan ada relasi produk
        }
        $order->total = $total;

        // Simpan perubahan pada pemesanan
        $order->save();

        return view('homepage');
    }
}
