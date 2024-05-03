<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Penitip;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PenitipController extends Controller
{

    /** 
     * index
     * 
     * @return void
    */

    public function index(Request $request) {
        $keyword = $request->input('keyword');
        
        $query = Penitip::query();
        
        if (!empty($keyword)) {
            $query->where('nama', 'LIKE', "%$keyword%");
        }
        
        $penitip = $query->orderBy('id_penitip', 'ASC')->paginate(5);
        
        if ($penitip->isEmpty()) {
            return view('viewAdmin.Penitip.index', compact('penitip', 'keyword'))->with('error', 'penitip tidak ditemukan.');
        }
        
        return view('viewAdmin.Penitip.index', compact('penitip', 'keyword'));
    }

    /**
     * create
     * 
     * @return void
     */

    public function create() {
        return view('viewAdmin.Penitip.create');
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
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'komisi' => 'required',
        ]);

        try{
            penitip::create($storeData);
            return redirect()->route('penitip')->with('success', 'Data penitip berhasil ditambahkan');
        }catch(Exception $e){
            return redirect()->route('penitip')->with('error', $e->getMessage());
        }
    }

    /**
     * edit
     * 
     * @param int $id
     * @return void
     */

    public function edit($id) {
        $penitip = Penitip::findOrFail($id);
        return view('viewAdmin.Penitip.edit', compact('penitip'));
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param int $id
     * @return void
     */

    public function update(Request $request, $id) {
        $penitip = Penitip::find($id);
        
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama' => 'required',
            'alamat' => 'required',
            'nomor_telepon' => 'required',
            'komisi' => 'required',
        ]);
        
        $penitip->update($storeData);

        return redirect()->route('penitip')->with(['success' => 'Data penitip Berhasil Diubah!']);
    }

    /**
     * destroy
     * 
     * @param int $id
     * @return void
     * 
     */

    public function destroy($id) {
        $penitip = Penitip::find($id);
        $penitip->delete();
        return redirect()->route('penitip')->with(['success' => 'Data penitip Berhasil Dihapus!']);
    }
}
