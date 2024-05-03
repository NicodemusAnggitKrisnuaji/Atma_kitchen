<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{

    /** 
     * index
     * 
     * @return void
    */

    public function index(Request $request) {
        $keyword = $request->input('keyword');
        
        $query = Karyawan::query();
        
        if (!empty($keyword)) {
            $query->where('nama_karyawan', 'LIKE', "%$keyword%");
        }
        
        $karyawan = $query->orderBy('id_karyawan', 'ASC')->paginate(5);
        
        if ($karyawan->isEmpty()) {
            return view('viewAdmin.Karyawan.index', compact('karyawan', 'keyword'))->with('error', 'Karyawan tidak ditemukan.');
        }
        
        return view('viewAdmin.Karyawan.index', compact('karyawan', 'keyword'));
    }

    /**
     * create
     * 
     * @return void
     */

    public function create() {
        return view('viewAdmin.Karyawan.create');
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
            'nama_karyawan' => 'required',
            'alamat_karyawan' => 'required',
            'tanggal_lahir' => 'required',
            'honor_harian' => 'required',
            'bonus_rajin' => 'required',
        ]);

        try{
            Karyawan::create($storeData);
            return redirect()->route('karyawan')->with('success', 'Data Karyawan berhasil ditambahkan');
        }catch(Exception $e){
            return redirect()->route('karyawan')->with('error', $e->getMessage());
        }
    }

    /**
     * edit
     * 
     * @param int $id
     * @return void
     */

    public function edit($id) {
        $karyawan = Karyawan::findOrFail($id);
        return view('viewAdmin.Karyawan.edit', compact('karyawan'));
    }

    /**
     * update
     * 
     * @param mixed $request
     * @param int $id
     * @return void
     */

    public function update(Request $request, $id) {
        $karyawan =Karyawan::find($id);
        
        $storeData = $request->all();
        $validate = Validator::make($storeData, [
            'nama_karyawan' => 'required',
            'alamat_karyawan' => 'required',
            'tanggal_lahir' => 'required',
            'honor_harian' => 'required',
            'bonus_rajin' => 'required',
        ]);
        
        $karyawan->update($storeData);

        return redirect()->route('karyawan')->with(['success' => 'Data Karyawan Berhasil Diubah!']);
    }

    /**
     * destroy
     * 
     * @param int $id
     * @return void
     * 
     */

    public function destroy($id) {
        $karyawan =Karyawan::find($id);
        $karyawan->delete();
        return redirect()->route('karyawan')->with(['success' => 'Data Karyawan Berhasil Dihapus!']);
    }
}
