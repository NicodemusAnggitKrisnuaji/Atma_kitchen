<?php

namespace App\Http\Controllers;

use App\Models\bahanBaku;
use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\Cart;
use App\Models\Detail_hampers;
use App\Models\Detail_reseps;
use App\Models\Resep;
use App\Models\Produk;
use App\Models\Hampers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PemesananController extends Controller
{
    public function show($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            abort(404, 'Produk Tidak Ditemukan');
        }

        return view('pemesanan', compact('produk'));
    }

    public function addToCart(Request $request)
    {
        $user_id = Auth::id();

        // Panggil fungsi untuk membuat pemesanan baru
        $order = $this->createPemesanan();

        // Tambahkan pemeriksaan jika order tidak berhasil dibuat
        if (!$order) {
            return redirect()->back()->with('error', 'Failed to create order');
        }

        $produk = Produk::findOrFail($request->id_produk);

        $cek = Pemesanan::where('id_user', $user_id)
        ->where('status', 'belum dibayar')
        ->latest()
        ->first();

        if ($cek) {
            Cart::create([
                'jumlah' => $request->jumlah,
                'id_produk' => $request->id_produk ?? null,
                'id_pemesanan' => $cek->id_pemesanan,
                'id_hampers' => $request->id_hampers ?? null,
                'harga' => $produk->harga_produk
            ]);

            // Hitung total belanjaan
            $cart_items = Cart::where('id_pemesanan', $cek->id_pemesanan)->get();
            $total = 0;
            foreach ($cart_items as $item) {
                $total += $item->jumlah * $item->produk->harga_produk;
            }

            // Simpan total belanjaan ke dalam pesanan
            $order->total = $total;
            $order->save();

            return view('catalog');
        } else {
            return redirect()->back()->with('error', 'Failed to find order for user');
        }
    }

    public function createPemesanan()
    {
        $user_id = Auth::id();

        $last_order = Pemesanan::where('id_user', $user_id)
            ->where('status', 'belum dibayar')
            ->latest()
            ->first();
        
        if (
            $last_order && $last_order->status !== 'sudah dibayar' && $last_order->status !== 'pembayaran valid' && $last_order->status !== 'diterima' && $last_order->status !== 'ditolak' && $last_order->status !== 'diproses'
            && $last_order->status !== 'siap di-pickup' && $last_order->status !== 'sedang dikirim kurir' && $last_order->status !== 'sudah di pickup' && $last_order->status !== 'selesai'
        ) {
            $order = new Pemesanan();

            if ($order->id_pemesanan !== $last_order->id_pemesanan) {
                $order->id_user = $user_id;
                $order->tanggal_pesan = Carbon::now();
                $order->tanggal_lunas = null;
                $order->tanggal_ambil = Carbon::now()->addDays(3);
                $order->jenis_pengiriman = null;
                $order->status = 'belum dibayar';
                $order->bukti = null;
                $order->total = null;
                $order->save();
            } else {
                $order = $last_order;
            }
        } else {
            $order = new Pemesanan();
            $order->id_pemesanan = $order->id_pemesanan;
            $order->id_user = $user_id;
            $order->tanggal_pesan = Carbon::now();
            $order->tanggal_lunas = null;
            $order->tanggal_ambil = Carbon::now()->addDays(3);
            $order->jenis_pengiriman = null;
            $order->status = 'belum dibayar';
            $order->bukti = null;
            $order->total = null;
            $order->save();
        }

        // Kembalikan pesanan yang baru dibuat
        return $order;
    }

    public function statusIndex(Request $request)
    {
        // Menggunakan whereIn untuk memfilter berdasarkan beberapa status
        $statusIndex = Pemesanan::whereIn('status', [
            'diproses', 
            'siap di-pickup', 
        ])->paginate(10);

        // Mengambil detail cart untuk setiap pemesanan
        $cart = [];

        foreach ($statusIndex as $pemesanan) {
            $carts = Cart::where('id_pemesanan', $pemesanan->id_pemesanan)->get();
            foreach ($carts as $cartItem) {
                if ($cartItem->id_produk !== null) {
                    $cart[] = $cartItem->produk->nama_produk;
                }

                if ($cartItem->id_hampers !== null) {
                    $cart[] = $cartItem->hampers->nama_hampers;
                }
            }
        }

        return view('viewAdmin.status.index', compact('statusIndex', 'cart'));
    }

    public function statusUpdate(Request $request, $id)
    {
        $Pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:siap di-pickup,sedang dikirim kurir,sudah di pickup,diambil sendiri',
        ]);

        // Set nilai status dari request langsung
        $statusBaru = $request->input('status');

        // Jika statusnya diambil sendiri, ubah menjadi selesai
        if ($statusBaru === 'diambil sendiri') {
            $statusBaru = 'selesai';
        }

        $Pemesanan->status = $statusBaru;

        $Pemesanan->save();

        return redirect()->back()->with('success', 'Pemesanan telah diperbarui.');
    }

    

    public function showCompletedOrders() {
        // Dapatkan ID pengguna yang sedang login
        $user_id = Auth::id();
    
        // Menggunakan metode whereIn untuk memilih status yang sesuai
        $showCompletedOrders = Pemesanan::where('id_user', $user_id)
            ->whereIn('status', ['sudah di pickup', 'sedang dikirim kurir'])
            ->paginate(10); // Menggunakan paginate untuk membatasi jumlah pesanan per halaman
    
        $cart = [];
    
        foreach ($showCompletedOrders as $pemesanan) {
            $carts = Cart::where('id_pemesanan', $pemesanan->id_pemesanan)->get();
            foreach ($carts as $cartItem) {
                if ($cartItem->id_produk !== null) {
                    $cart[] = $cartItem->produk->nama_produk;
                }
    
                if ($cartItem->id_hampers !== null) {
                    $cart[] = $cartItem->hampers->nama_hampers;
                }
            }
        }
    
        // Mengembalikan data pesanan beserta cart-nya ke view
        return view('contentCustomer.penerimaan', compact('showCompletedOrders', 'cart'));
    }

    public function updateCompletedOrders(Request $request, $id)
    {
        // Dapatkan ID pengguna yang sedang login
        $user_id = Auth::id();
        
        // Temukan pesanan berdasarkan ID-nya
        $Pemesanan = Pemesanan::where('id_pemesanan', $id)
                            ->where('id_user', $user_id)
                            ->firstOrFail();

        // Validasi permintaan
        $request->validate([
            'status' => 'required',
        ]);

        // Ubah status pesanan menjadi 'selesai'
        $Pemesanan->status = 'selesai';

        // Simpan perubahan status pesanan
        $Pemesanan->save();

        return redirect()->back();
    }

    public function latePaymentsIndex(Request $request)
    {
        $latePayments = Pemesanan::where('status', 'telat bayar')->paginate(10);

        $cart = [];

        foreach ($latePayments as $pemesanan) {
            $carts = Cart::where('id_pemesanan', $pemesanan->id_pemesanan)->get();
            foreach ($carts as $cartItem) {
                if ($cartItem->id_produk !== null) {
                    $cart[] = $cartItem->produk->nama_produk;
                }

                if ($cartItem->id_hampers !== null) {
                    $cart[] = $cartItem->hampers->nama_hampers;
                }
            }
        }

        return view('viewAdmin.pembatalan.index', compact('latePayments', 'cart'));
    }

    public function latePaymentsUpdate(Request $request, $id)
    {
        $Pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'status' => 'required',
        ]);

        if ($request->input('status') == 'batal') {
            $Pemesanan->status = 'batal';
            $this->restoreStock($Pemesanan->id_pemesanan);
        }

        $Pemesanan->save();

        return redirect()->route('orders.pembatalan')->with('success', 'Pemesanan telah diperbarui.');
    }

    public function index(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $Pemesanans = Pemesanan::where('status', 'pembayaran valid')
            ->where(function ($query) use ($keyword) {
                if ($keyword) {
                    $query->where('nama', 'like', "%{$keyword}%");
                }
            })
            ->paginate(10);

        $cart = [];
        foreach ($Pemesanans as $pemesanan) {
            $carts = Cart::where('id_pemesanan', $pemesanan->id_pemesanan)->get();
            foreach ($carts as $cartItem) {
                if ($cartItem->id_produk !== null) {
                    $cart[] = $cartItem->produk->nama_produk;
                }

                if ($cartItem->id_hampers !== null) {
                    $cart[] = $cartItem->hampers->nama_hampers;
                }
            }
        }
        return view('viewAdmin.konfirmasiMO.index', compact('Pemesanans', 'cart'));
    }

    public function update(Request $request, $id)
    {
        $Pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        if ($request->input('status') == 'diterima') {
            $Pemesanan->status = 'diterima';
            $this->storeCustomerPoints($Pemesanan);

            $requiredMaterials = $this->checkMaterialsAvailability($Pemesanan->id_pemesanan);

            if (!empty($requiredMaterials)) {
                session(['requiredMaterials' => $requiredMaterials]);
                return redirect()->route('orders.material-list');
            } else {
                $this->reduceMaterialsStock($Pemesanan->id_pemesanan);
            }
        } elseif ($request->input('status') == 'ditolak') {
            $Pemesanan->status = 'ditolak';
            $this->restoreStock($Pemesanan->id_pemesanan);
            $this->refundCustomer($Pemesanan->id_user, $Pemesanan->total);
        }

        $Pemesanan->save();

        return redirect()->route('orders.index')->with('success', 'Pemesanan telah diperbarui.');
    }

    public function showMaterialList()
    {
        $requiredMaterials = session('requiredMaterials', []);

        return view('viewAdmin.konfirmasiMO.material_list', compact('requiredMaterials'));
    }

    private function checkMaterialsAvailability($id)
    {
        $carts = Cart::where('id_pemesanan', $id)->get();

        $requiredMaterials = [];

        foreach ($carts as $cartItem) {
            $item = null;

            if ($cartItem->id_produk !== null) {
                $item = Produk::find($cartItem->id_produk);

                if ($item) {
                    $resep = Resep::where('id_produk', $item->id_produk)->first();

                    if ($resep) {
                        $detail_reseps = Detail_reseps::where('id_resep', $resep->id_resep)->get();

                        foreach ($detail_reseps as $detail) {

                            $material = bahanBaku::find($detail->id_bahanBaku);
                            $requiredAmount = $detail->jumlah * $cartItem->jumlah;

                            if ($material->stock < $requiredAmount) {
                                // If stock is insufficient, add to the list of materials to be purchased
                                $requiredMaterials[$material->nama] = $requiredAmount - $material->stock;
                            }
                        }
                    }
                }
            }

            if ($cartItem->id_hampers !== null) {
                $item = Hampers::find($cartItem->id_hampers);

                if ($item) {
                    $detail_hampers = Detail_hampers::where('id_hampers', $item->id_hampers)->get();

                    foreach ($detail_hampers as $detail) {
                        $material = bahanBaku::find($detail->id_bahanBaku);
                        $requiredAmount = $detail->jumlah * $cartItem->jumlah;

                        if ($material->stock < $requiredAmount) {
                            $requiredMaterials[$material->nama] = $requiredAmount - $material->stock;
                        }
                    }
                }
            }
        }

        return $requiredMaterials;
    }

    private function reduceMaterialsStock($orderId)
    {
        $carts = Cart::where('id_pemesanan', $orderId)->get();

        foreach ($carts as $cartItem) {
            if ($cartItem->id_produk !== null) {
                $item = Produk::find($cartItem->id_produk);

                if ($item) {
                    $resep = Resep::where('id_produk', $item->id_produk)->first();

                    if ($resep) {
                        $detail_reseps = Detail_reseps::where('id_resep', $resep->id_resep)->get();

                        foreach ($detail_reseps as $detail) {
                            $material = bahanBaku::find($detail->id_bahanBaku);
                            $requiredAmount = $detail->jumlah * $cartItem->jumlah;

                            if ($material->stock >= $requiredAmount) {
                                $material->stock -= $requiredAmount;
                                $material->save();
                            }
                        }
                    }
                }
            }

            if ($cartItem->id_hampers !== null) {
                $item = Hampers::find($cartItem->id_hampers);

                if ($item) {
                    $detail_hampers = Detail_hampers::where('id_hampers', $item->id_hampers)->get();

                    foreach ($detail_hampers as $detail) {
                        $material = bahanBaku::find($detail->id_bahanBaku);
                        $requiredAmount = $detail->jumlah * $cartItem->jumlah;

                        if ($material->stock >= $requiredAmount) {
                            $material->stock -= $requiredAmount;
                            $material->save();
                        }
                    }
                }
            }
        }
    }

    private function restoreStock($id)
    {
        $carts = Cart::where('id_pemesanan', $id)->get();

        foreach ($carts as $cart) {
            $product = $cart->produk;

            if ($product) {
                $product->stock += $cart->jumlah;
                $product->quota += $cart->jumlah;
                $product->save();
            }

            $hampers = $cart->hampers;

            if ($hampers) {
                $hampers->stock += $cart->jumlah;
                $hampers->quota += $cart->jumlah;
                $hampers->save();
            }
        }
    }

    private function storeCustomerPoints(Pemesanan $Pemesanan)
    {
        $customer = User::findOrFail($Pemesanan->id_user);
        $PemesananTotal = $Pemesanan->total;
        $points = 0;

        if ($PemesananTotal >= 1000000) {
            $points += 200 * floor($PemesananTotal / 1000000);
            $PemesananTotal %= 1000000;
        }
        if ($PemesananTotal >= 500000) {
            $points += 75 * floor($PemesananTotal / 500000);
            $PemesananTotal %= 500000;
        }
        if ($PemesananTotal >= 100000) {
            $points += 15 * floor($PemesananTotal / 100000);
            $PemesananTotal %= 100000;
        }
        if ($PemesananTotal >= 10000) {
            $points += 1 * floor($PemesananTotal / 10000);
        }

        $today = Carbon::today();
        $birthday = Carbon::parse($customer->tanggal_lahir)->setYear($today->year);
        $birthdayStart = $birthday->copy()->subDays(3);
        $birthdayEnd = $birthday->copy()->addDays(3);

        if ($today->between($birthdayStart, $birthdayEnd)) {
            $points *= 2;
        }

        $customer->poin += $points;
        $customer->save();
    }

    private function refundCustomer($customerId, $amount)
    {
        $customer = User::findOrFail($customerId);
        $customer->saldo += $amount;
        $customer->save();
    }

    public function storeMaterialUsage($materialUsage, $Pemesanan)
    {
        foreach ($materialUsage as $materialName => $usedAmount) {
            $material = bahanBaku::where('nama', $materialName)->first();

            if ($material) {
                PenggunaanBahanBaku::create([
                    'id_bahanBaku' => $material->id_bahanBaku,
                    'jumlah' => $usedAmount,
                    'id_pemesanan' => $Pemesanan->id_pemesanan, 
                ]);
            }
        }
    }
}
