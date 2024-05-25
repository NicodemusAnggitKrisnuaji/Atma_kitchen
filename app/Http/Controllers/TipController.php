<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Tip;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TipController extends Controller
{
    
    /**
     * index
     *
     * @return void
     * 
     */

    public function index() {
        $tip = Tip::orderBy('id_tip', 'DESC')->paginate(5);

        return view('viewAdmin.Tip.index', compact('tip'));
    }

    public function create()
    {
        $pemesanan = Pemesanan::all();
        return view('viewAdmin.Tip.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $storeData = $request->validate([
            'id_pemesanan' => 'required',
            'total' => 'required',
            'jumlah' => 'required',
        ]);

        $id_pemesanan = $request->id_pemesanan;
        $pemesanan = Pemesanan::where('id_pemesanan', $id_pemesanan)->first();

        if (!$pemesanan) {
            return redirect()->route('pengiriman')->with(['error' => 'Tidak ada pesanan!']);
        }

        $storeData['id_pemesanan'] = $pemesanan->id_pemesanan;

        // Hitung kelebihan pembayaran sebagai tip
        $total = $request->total;
        $jumlah = $request->jumlah;
        $tip = $jumlah - $total;
        $pemesanan->status= $request->status;

        $pemesanan->save();

        // Pastikan tip tidak negatif
        if ($tip < 0) {
            return redirect()->route('tip')->with(['error' => 'Jumlah pembayaran kurang dari total!']);
        }

        try {
            Tip::create($storeData + ['hasil_tip' => $tip]);
            return redirect()->route('tip')->with('success', 'Tip berhasil dihitung.');
        } catch (\Exception $e) {
            return redirect()->route('tip')->with(['error' => 'Terjadi kesalahan saat menghitung tip: ' . $e->getMessage()]);
        }
    }
}
