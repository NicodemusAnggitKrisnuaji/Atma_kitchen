<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class GajiBonusController extends Controller
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
            return view('viewAdmin.Gaji.index', compact('karyawan', 'keyword'))->with('error', 'Karyawan tidak ditemukan.');
        }
        
        return view('viewAdmin.Gaji.index', compact('karyawan', 'keyword'));
    }

    /**
     * edit
     * 
     * @param int $id
     * @return void
     */

    public function edit($id) {
        $karyawan = Karyawan::findOrFail($id);
        return view('viewAdmin.Gaji.edit', compact('karyawan'));
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
            'honor_harian' => 'required',
            'bonus_rajin' => 'required',
        ]);
        
        $karyawan->update($storeData);

        return redirect()->route('gaji')->with(['success' => 'Data Karyawan Berhasil Diubah!']);
    }

}
