<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Penitip;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProdukController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $query = Produk::query();
    
        if (!empty($keyword)) {
            $query->where(function($query) use ($keyword) {
                $query->where('nama_produk', 'LIKE', "%$keyword%")
                       ->orWhere('harga_produk', 'LIKE', "%$keyword%")
                      ->orWhere('stock', 'LIKE', "%$keyword%")
                      ->orWhere('kategori', 'LIKE', "%$keyword%");
            });
        }
    
        // Mengganti pengurutan default 'latest()' dengan 'orderBy()'
        $produk = $query->orderBy('id_produk', 'ASC')->paginate(5);
    
        if ($produk->isEmpty()) {
            return view('viewAdmin.Produk.index', compact('produk', 'keyword'))->with('error', 'Pencarian Tidak Ditemukan.');
        }
    
        return view('viewAdmin.Produk.index', compact('produk', 'keyword'));
    }

    /**
     * create
     * 
     * @return void
     */
    public function create()
    {
        $penitip = Penitip::all();
        return view('viewAdmin.Produk.create', compact('penitip'));
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
        $id_penitip = $storeData['id_penitip'];
        $penitip = Penitip::where('id_penitip', $id_penitip)->first();

        if (!$penitip) {
            $storeData['id_penitip'] = null;
        } else {
            $storeData['id_penitip'] = $penitip->id_penitip;
        }
    
        $validate = Validator::make($storeData, [
            'nama_produk' => 'required',
            'id_penitip',
            'harga_produk' => 'required',
            'stock' => 'required',
            'deskripsi_produk' => 'required',
            'kategori' => 'required',
            'image' => 'required'
        ]);

        if($validate->fails())
        {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        if($request->hasfile('image'))
        {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fotoKue'), $imageName);
            $storeData['image'] = $imageName;
        }

        try{
            Produk::create($storeData);
            return redirect()->route('produk')->with(['success' => 'Data Berhasil Disimpan']);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('produk')->with(['error' => 'Produk Tidak Ditemukan!']);
        } catch (\Exception $e) {
            return redirect()->route('produk')->with(['error' => 'Terjadi Kesalahan Saat Mengubah Data!']);
        }
    }

    /**
     * edit
     * 
     * @param int $id
     * @return void
     */
    public function edit($id_produk)
    {
        $produk = Produk::find($id_produk);
        $penitip = Penitip::all();
        return view('viewAdmin.Produk.edit', compact('produk', 'penitip'));
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
        $produk = Produk::find($id);

        if(!$produk)
        {
            return redirect()->route('produk.index')->with(['error' => 'Produk Tidak Ditemukan']);
        }

        $validate = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'harga_produk' => 'required',
            'stock' => 'required',
            'deskripsi_produk' => 'required',
            'kategori' => 'required',
    
        ]);

        if($validate->fails())
        {
            return redirect()->back()->withErrors($validate)->withInput();
        }

        $storeData = $request->all();

        if ($request->hasfile('image'))
        {
            
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('fotoKue'), $imageName);
            $storeData['image'] = $imageName;

            if(file_exists(public_path('fotoKue/'. $produk->image)))
            {
                unlink(public_path('fotoKue/'. $produk->image));
            }

        }

        try {
            $produk->update($storeData);
            return redirect()->route('produk')->with(['success' => 'Data Berhasil Diubah!']);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('produk')->with(['error' => 'Produk Tidak Ditemukan!']);
        } catch (\Exception $e) {
            return redirect()->route('produk')->with(['error' => 'Terjadi Kesalahan Saat Mengubah Data!']);
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
        $produk = Produk::find($id);

        if($produk) {
            $produk->delete();
            return redirect()->route('produk')->with(['success' => 'Data Berhasil Dihapus!']);
        } else {
            return redirect()->route('produk')->with(['error' => 'Terjadi Kesalahan Saat Menghapus Data!']);
        }
    }
}

