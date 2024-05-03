<?php

namespace App\Http\Controllers;

use App\Models\Resep;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ResepController extends Controller
{
    /**
     * index
     * 
     * @return void
     * 
     */

    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        // Ambil semua data resep
        $query = Resep::query();

        // Jika ada kata kunci pencarian, filter data berdasarkan kata kunci
        if (!empty($keyword)) {
            $query->where('nama_resep', 'LIKE', "%$keyword%")
                ->orWhere('prosedur', 'LIKE', "%$keyword%");
        }

        // Panggil paginate setelah menerapkan filter
        $resep = $query->orderBy('id_resep', 'DESC')->paginate(5);

        // Jika hasil pencarian kosong, tampilkan pesan yang sesuai
        if ($resep->isEmpty()) {
            return view('viewAdmin.Resep.index', compact('resep', 'keyword'))->with('error', 'Pencarian tidak ditemukan.');
        }

        return view('viewAdmin.Resep.index', compact('resep', 'keyword'));
    }



    public function create()
    {
        $produk = Produk::all();
        return view('viewAdmin.Resep.create', compact('produk'));
    }

    public function store(Request $request)
    {
        $storeData = $request->all();

        $id_produk = $storeData['id_produk'];
        $produk = Produk::where('id_produk', $id_produk)->first();

        if (!$produk) {
            return redirect()->route('resep')->with(['error' => 'Produk Tidak Ditemukan!']);
        }

        $storeData['id_produk'] = $produk->id_produk;

        $validate = Validator::make($storeData, [
            'id_produk' => 'required',
            'nama_resep' => 'required',
            'prosedur' => 'required'
        ]);

        try {
            Resep::create($storeData);
            return redirect()->route('resep')->with('success', 'Resep Berhasil Ditambah!');
        } catch (\Exception $e) {
            return redirect()->route('resep')->with(['error' => 'Terjadi Kesalahan Saat Menambahkan Resep!']);
        }
    }

    public function edit($id)
    {
        $resep = Resep::find($id);
        $produk = Produk::all();
        return view('viewAdmin.Resep.edit', compact('resep', 'produk'));
    }

    public function update(Request $request, $id)
    {
        // Temukan resep yang akan diperbarui
        $resep = Resep::find($id);

        // Validasi input
        $validate = Validator::make($request->all(), [
            'id_produk' => 'required',
            'nama_resep' => 'required',
            'prosedur' => 'required'
        ]);

        // Jika validasi gagal, kembalikan pengguna ke formulir dengan pesan kesalahan
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        // Temukan produk yang sesuai dengan id_produk yang dikirimkan
        $produk = Produk::find($request->id_produk);

        // Jika produk tidak ditemukan, kembalikan pesan error
        if (!$produk) {
            return redirect()->route('resep.edit', $id)->with(['error' => 'Produk Tidak Ditemukan!']);
        }

        // Perbarui data resep dengan data baru dari formulir
        $resep->id_produk = $produk->id_produk;
        $resep->nama_resep = $request->nama_resep;
        $resep->prosedur = $request->prosedur;

        // Simpan perubahan
        $resep->save();

        // Redirect dengan pesan sukses
        return redirect()->route('resep')->with(['success' => 'Resep Berhasil Diupdate!']);
    }

    public function destroy($id)
    {
        $resep = Resep::find($id);
        $resep->delete();
        return redirect()->route('resep')->with(['success' => 'Resep Berhasil Dihapus!']);
    }
}
