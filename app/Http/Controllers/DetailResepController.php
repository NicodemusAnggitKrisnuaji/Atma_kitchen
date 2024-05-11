<?php

namespace App\Http\Controllers;

use App\Models\bahanBaku;
use Exception;
use Illuminate\Http\Request;
use App\Models\Hampers;
use App\Models\Detail_reseps;
use App\Models\Resep;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DetailResepController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index($id)
    {
       
        $details = Detail_reseps::where('id_resep', $id)->paginate(5);
        $id_resep = $id;

        return view('viewAdmin.Detail_resep.index', compact('details', 'id_resep'));
    }


    /**
     * create
     * 
     * @return void
     */
    public function create($id)
    {
        $bahanBaku = bahanBaku::all();
        return view('viewAdmin.Detail_resep.create', compact('id', 'bahanBaku'));
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
            'id_bahanBaku' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();
        $storeData['id_resep'] = $id;
        try {
            Detail_reseps::create($storeData);
            return redirect()->route('detail_resep', $id)->with(['success' => 'Data Berhasil Disimpan']);
        } catch (Exception $e) {
            return redirect()->route('detail_resep', $id)->with(['error' => 'Terjadi Kesalahan Saat Menyimpan Data']);
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
        $bahanBaku = bahanBaku::all();
        $detail = Detail_reseps::where('id_detail', $id)->first();
        return view('viewAdmin.Detail_resep.edit', compact('detail', 'bahanBaku', 'id'));
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
        $detail = Detail_reseps::where('id_detail', $id)->first();
        if (!$detail) {
            return redirect()->route('detail_resep', $detail->id_resep)->with(['error' => 'Detail Hampers tidak ditemukan']);
        }

        $validate = Validator::make($request->all(), [
            'id_bahanBaku' => 'required',
            'jumlah' => 'required',
        ]);

        if ($validate->fails()) {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        try {
            $detail->update($storeData);
            return redirect()->route('detail_resep', $detail->id_resep)->with(['success' => 'Data Berhasil Diubah!']);
        } catch (Exception $e) {
            return redirect()->route('detail_resep', $detail->id_resep)->with(['error' => 'Terjadi Kesalahan Saat Mengubah Data!']);
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
        $hampers = Detail_reseps::find($id);

        if ($hampers) {
            $hampers->delete();
            return redirect()->route('detail_resep', $hampers->id_resep)->with(['success' => 'Data Berhasil Dihapus!']);
        }
        return redirect()->route('detail_resep', $hampers->id_resep)->with(['error' => 'Terjadi Kesalahan Saat Menghapus Data!']);
    }
}
