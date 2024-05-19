<?php

namespace App\Http\Controllers;

use App\Models\bahanBaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = bahanBaku::query();
        if (!empty($keyword)) {
            $query->where('nama', 'LIKE', "%$keyword%");
        }

        $bahanBaku = $query->orderBy('id_bahanBaku', 'ASC')->paginate(5);

        if ($bahanBaku->isEmpty()) {
            return view('viewAdmin.bahanBaku.index', compact('bahanBaku', 'keyword'))->with('error', 'Pencarian Tidak Ditemukan');
        }
        return view('viewAdmin.bahanBaku.index', compact('bahanBaku', 'keyword'));
    }



    public function create()
    {
        return view('viewAdmin.bahanBaku.create');
    }

    public function store(Request $request)
    {
        // Validasi input
        $validate = Validator::make($request->all(), [
            'nama' => 'required',
            'satuan' => 'required',
            'stock' => 'required',
        ]);

        // Jika validasi gagal, kembalikan pengguna ke formulir dengan pesan kesalahan
        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        try {
            // Buat entri baru menggunakan data dari formulir
            bahanBaku::create($request->all());

            // Redirect dengan pesan sukses
            return redirect()->route('bahanBaku')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            // Tangani pengecualian secara spesifik
            return redirect()->route('bahanBaku')->with(['error' => 'Terjadi Kesalahan Saat Menambah Data!']);
        }
    }


    public function edit($id)
    {
        $bahanBaku = bahanBaku::find($id);
        return view('viewAdmin.bahanBaku.edit', compact('bahanBaku'));
    }

    public function update(Request $request, $id)
    {
        $bahanBaku = bahanBaku::find($id);

        $this->validate($request, [
            'nama' => 'required|string',
            'satuan' => 'required|string',
            'stock' => 'required|integer',
        ]);

        $bahanBaku->update([
            'nama' => $request->nama,
            'satuan' => $request->satuan,
            'stock' => $request->stock,
        ]);

        return redirect()->route('bahanBaku')->with(['success' => 'Bahan Baku Berhasil Diupdate!']);
    }

    public function destroy(string $id)
    {
        $bahanBaku = bahanBaku::find($id);
        $bahanBaku->delete();
        return redirect()->back();
    }
}
