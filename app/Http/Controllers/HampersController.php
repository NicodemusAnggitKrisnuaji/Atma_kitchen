<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Models\Hampers;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class HampersController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Hampers::query();

        if(!empty($kwyword))
        {
            $query->where('nama_paketHampers', 'LIKE', "%$keyword%");
        }

        $hampers = $query->orderBy('id_hampers', 'ASC')->paginate(5);
        if($hampers->isEmpty())
        {
            return view('viewAdmin.Hampers.index', compact('hampers', 'keyword'))->with('error', 'Pencarian Tidak Ditemukab');
        }

        return view('viewAdmin.Hampers.index', compact('hampers', 'keyword'));
    }

    /**
     * create
     * 
     * @return void
     */
    public function create()
    {
        return view('viewAdmin.Hampers.create');
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
            'nama_hampers' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'isi' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);

        if($validate->fails())
        {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        if($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fotoHampers'), $imageName);
            $storeData['image'] = $imageName;
        }

        try{
            Hampers::create($storeData);
            return redirect()->route('hampers')->with(['success' => 'Data Berhasil Disimpan']);
        }catch(Exception $e) {
            return redirect()->route('hampers')->with(['error' => 'Terjadi Kesalahan Saat Menyimpan Data']);
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
        $hampers = Hampers::find($id);
        return view('viewAdmin.Hampers.edit', compact('hampers'));
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
        $hampers = Hampers::find($id);

        if(!$hampers)
        {
            return redirect()->route('viewAdmin.Hampers.index')->with(['error' => 'Hampers Tidak Ditemukan']);
        }

        $validate = Validator::make($request->all(), [
            'nama_hampers' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required',
            'isi' => 'required',
            'stock' => 'required',
            'image' => 'required'
        ]);

        if($validate->fails())
        {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        if ($request->hasFile('image'))
        {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fotoHampers'), $imageName);
            $storeData['image'] = $imageName;

            if(file_exists(public_path('fotoHampers/'. $hampers->image)))
            {
                unlink(public_path('fotoHampers/'. $hampers->image));
            }
        }

        try {
            $hampers->update($storeData);
            return redirect()->route('hampers')->with(['success' => 'Data Berhasil Diubah!']);
        } catch (Exception $e) {
            return redirect()->route('hampers')->with(['error' => 'Terjasi Kesalahan Saat Mengubah Data!']);
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
        $hampers = hampers::find($id);

        if($hampers) {
            $hampers->delete();
            return redirect()->route('hampers')->with(['success' => 'Data Berhasil Dihapus!']);
        }
            return redirect()->route('hampers')->with(['error' => 'Terjadi Kesalahan Saat Menghapus Data!']);
    }
}
