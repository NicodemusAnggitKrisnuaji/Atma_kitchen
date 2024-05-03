<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PembelianBahanBaku;
use App\Models\BahanBaku;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PembelianBahanBakuController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = PembelianBahanBaku::query()->join('bahan_bakus', 'pembelian_bahan_bakus.id_bahanBaku', '=', 'bahan_bakus.id_bahanBaku');

        if (!empty($keyword)) {
            $query->where('bahan_bakus.nama', 'LIKE', "%$keyword%")
                ->orWhere('tanggal_pembelian', 'LIKE', "%$keyword%");
        }

        $pembelian = $query->orderBy('id_pembelian', 'ASC')->paginate(5);

        if ($pembelian->isEmpty()) {
            return view('viewAdmin.Pembelian.index', compact('pembelian', 'keyword'))->with('error', 'Pencarian Tidak Ditemukan');
        }

        return view('viewAdmin.Pembelian.index', compact('pembelian', 'keyword'));
    }



    /**
     * create
     * 
     * @return void
     */
    public function create()
    {
        $bahanBaku = BahanBaku::all();
        return view('viewAdmin.Pembelian.create', compact('bahanBaku'));
    }

    /**
     * store
     * 
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'id_bahanBaku' => 'required',
            'tanggal_pembelian' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        try {
            PembelianBahanBaku::create($storeData);
            return redirect()->route('pembelian')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pembelian')->with(['error' => 'Produk Tidak Ditemukan!']);
        } catch (\Exception $e) {
            return redirect()->route('pembelian')->with(['error' => 'Terjadi Kesalahan Saat Mengubah Data!']);
        }
    }

    /**
     * edit
     * 
     * @param int $id
     * #return void
     */
    public function edit($id)
    {
        $pembelian = PembelianBahanBaku::find($id);
        $bahanBaku = BahanBaku::all();
        return view('viewAdmin.Pembelian.edit', compact('pembelian', 'bahanBaku'));
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, $id)
    {
        $pembelian = PembelianBahanBaku::find($id);

        if (!$pembelian) {
            return redirect()->route('pembelian')->with(['error' => 'Pembelian Tidak Ditemukan']);
        }

        $validate = Validator::make($request->all(), [
            'id_bahanBaku' => 'required',
            'tanggal_pembelian' => 'required',
            'jumlah' => 'required',
            'total_harga' => 'required'
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        try {
            $pembelian->update($storeData); // Menggunakan metode update untuk memperbarui data
            return redirect()->route('pembelian')->with(['success' => 'Data Berhasil Diubah']);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('pembelian')->with(['error' => 'Produk Tidak Ditemukan!']);
        } catch (\Exception $e) {
            return redirect()->route('pembelian')->with(['error' => 'Terjadi Kesalahan Saat Mengubah Data!']);
        }
    }

    /**
     * destroy
     * 
     * @param int $id
     * @return void
     */
    public function destroy($id)
    {
        $pembelian = PembelianBahanBaku::find($id);

        if ($pembelian) {
            $pembelian->delete();
            return redirect()->route('pembelian')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('pembelian')->with(['error' => 'Terjadi Kesalahan Saat Menghapus Data!']);
        }
    }
}
