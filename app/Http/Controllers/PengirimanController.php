<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PengirimanController extends Controller
{
    /**
     * index
     *
     * @return void
     */

    public function index() {
        // Mengambil data pengiriman yang hanya memiliki jenis pengiriman 'diantar' di tabel pemesanan
        $pengiriman = Pengiriman::whereHas('pemesanan', function($query) {
            $query->where('jenis_pengiriman', 'diantar');
        })->orderBy('id_pengiriman', 'DESC')->paginate(5);

        return view('viewAdmin.Pengiriman.index', compact('pengiriman'));
    }

    public function create()
    {
        $pemesanan = Pemesanan::all();
        return view('viewAdmin.Pengiriman.create', compact('pemesanan'));
    }

    public function store(Request $request)
    {
        $storeData = $request->all();

        $id_pemesanan = $request->id_pemesanan;
        $pemesanan = Pemesanan::where('id_pemesanan', $id_pemesanan)->first();

        if (!$pemesanan) {
            return redirect()->route('pengiriman')->with(['error' => 'Tidak ada pesanan!']);
        }

        $storeData['id_pemesanan'] = $pemesanan->id_pemesanan;

        $validate = Validator::make($storeData, [
            'id_pemesanan' => 'required',
            'jarak' => 'required',
            'total' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            Pengiriman::create($storeData);
            return redirect()->route('pengiriman')->with('success', 'Berhasil menginput jarak dan total!');
        } catch (\Exception $e) {
            return redirect()->route('pengiriman')->with(['error' => 'Terjadi Kesalahan Saat Menambahkan Jarak! ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $pengiriman = Pengiriman::find($id);
        $pemesanan = Pemesanan::all();
        return view('viewAdmin.Pengiriman.edit', compact('pengiriman', 'pemesanan'));
    }

    public function update(Request $request, $id)
    {
        $pengiriman = Pengiriman::find($id);

        $validate = Validator::make($request->all(), [
            'id_pemesanan' => 'required',
            'jarak' => 'required',
            'total' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $pemesanan = Pemesanan::find($request->id_pemesanan);

        if (!$pemesanan) {
            return redirect()->route('pengiriman.edit', $id)->with(['error' => 'Pemesanan Tidak Ditemukan!']);
        }

        $pengiriman->id_pemesanan = $pemesanan->id_pemesanan;
        $pengiriman->jarak = $request->jarak;
        $pengiriman->total = $request->total;

        $pengiriman->save();

        return redirect()->route('pengiriman')->with(['success' => 'Jarak Berhasil Diupdate!']);
    }

    public function destroy($id)
    {
        $pengiriman = Pengiriman::find($id);
        $pengiriman->delete();
        return redirect()->route('pengiriman')->with(['success' => 'Jarak Berhasil Dihapus!']);
    }
}


