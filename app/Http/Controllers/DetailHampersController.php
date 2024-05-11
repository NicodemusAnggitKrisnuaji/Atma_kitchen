<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Hampers;
use App\Models\Detail_hampers;
use App\Models\Produk;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DetailHampersController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index($id)
    {
        // Retrieving details of hampers based on the provided $id, paginating the results with 5 items per page
        $details = Detail_hampers::where('id_hampers', $id)->paginate(5);

        // Assigning the $id value to $id_hampers variable
        $id_hampers = $id;

        // Returning the view with the details and the $id_hampers variable
        return view('viewAdmin.Detail_hampers.index', compact('details', 'id_hampers'));
    }


    /**
     * create
     * 
     * @return void
     */
    public function create($id)
    {
        $produk = Produk::all();
        return view('viewAdmin.Detail_hampers.create', compact('id', 'produk'));
    }
    /**
     * store
     * 
     * @param Request $request
     * @return void
     */
    public function store(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();
        $storeData['id_hampers'] = $id;
        try {
            Detail_hampers::create($storeData);
            return redirect()->route('detail_hampers', $id)->with(['success' => 'Data Berhasil Disimpan']);
        } catch (Exception $e) {
            return redirect()->route('detail_hampers')->with(['error' => 'Terjadi Kesalahan Saat Menyimpan Data']);
        }
    }

    /**
     * edit
     * 
     * @param int
     * @return void
     */
    public function edit($id)
    {
        $produk = Produk::all();
        $detail = Detail_hampers::where('id_detail', $id)->first();
        return view('viewAdmin.Detail_hampers.edit', compact('detail', 'produk', 'id'));
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
        $detail = Detail_hampers::where('id_detail', $id)->first();
        if (!$detail) {
            return redirect()->route('detail_hampers', $detail->id_hampers)->with(['error' => 'Detail Hampers tidak ditemukan']);
        }

        $validate = Validator::make($request->all(), [
            'id_produk' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        try {
            $detail->update($storeData);
            return redirect()->route('detail_hampers', $detail->id_hampers)->with(['success' => 'Data Berhasil Diubah!']);
        } catch (Exception $e) {
            return redirect()->route('detail_hampers', $detail->id_hampers)->with(['error' => 'Terjadi Kesalahan Saat Mengubah Data!']);
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
        $hampers = Detail_hampers::find($id);

        if ($hampers) {
            $hampers->delete();
            return redirect()->route('detail_hampers', $hampers->id_hampers)->with(['success' => 'Data Berhasil Dihapus!']);
        }
        return redirect()->route('detail_hampers', $hampers->id_hampers)->with(['error' => 'Terjadi Kesalahan Saat Menghapus Data!']);
    }
}
