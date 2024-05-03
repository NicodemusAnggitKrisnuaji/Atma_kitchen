<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\PencatatanPengeluaran;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PencatatanPengeluaranController extends Controller
{

    /** 
     * index
     * 
     * @return void
    */

    public function index(Request $request) {
        $keyword = $request->input('keyword');
        
        $query = PencatatanPengeluaran::query();
        
        if (!empty($keyword)) {
            $query->where('nama', 'LIKE', "%$keyword%")
                    ->orWhere('harga', 'LIKE', "%$keyword%");
        }
        
        $pencatatan = $query->orderBy('id_pencatatan', 'ASC')->paginate(5);
        
        if ($pencatatan->isEmpty()) {
            return view('viewAdmin.Pencatatan.index', compact('pencatatan', 'keyword'))->with('error', 'Pencatatan tidak ditemukan.');
        }
        
        return view('viewAdmin.Pencatatan.index', compact('pencatatan', 'keyword'));
    }

    /**
     * create
     * 
     * @return void
     */

    public function create() {
        return view('viewAdmin.Pencatatan.create');
    }

    /**
     * store
     * 
     * @param Request $request
     * @return void
     */

    public function store(Request $request) {
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'harga' => 'required',
        ]);

        try{
            PencatatanPengeluaran::create($storeData);
            return redirect()->route('pencatatan')->with('success', 'Data Karyawan berhasil ditambahkan');
        }catch(Exception $e){
            return redirect()->route('pencatatan')->with('error', $e->getMessage());
        }
    }

    /**
     * edit
     * 
     * @param int $id
     * @return void
     */

    public function edit($id) {
        $pencatatan = PencatatanPengeluaran::findOrFail($id);
        return view('viewAdmin.Pencatatan.edit', compact('pencatatan'));
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param int $id
     * @return void
     */

     public function update(Request $request, $id) {
        $pencatatan = PencatatanPengeluaran::find($id);
        
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'harga' => 'required',
        ]);
        
        $pencatatan->update($storeData);

        return redirect()->route('pencatatan')->with(['success' => 'Data pencatatan Berhasil Diubah!']);
    }

    /**
     * destroy
     * 
     * @param int $id
     * @return void
     * 
     */

    public function destroy($id) {
        $pencatatan =PencatatanPengeluaran::find($id);
        $pencatatan->delete();
        return redirect()->route('pencatatan')->with(['success' => 'Data pencatatan Berhasil Dihapus!']);
    }
}
