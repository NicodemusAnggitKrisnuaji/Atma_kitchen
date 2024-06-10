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

        // Call the createPemesanan function to either create a new order or get the existing one
        $order = $this->createPemesanan();

        // Check if the order creation or retrieval was successful
        if (!$order) {
            return redirect()->back()->with('error', 'Failed to create or retrieve order');
        }

        $produk = Produk::findOrFail($request->id_produk);

        // Check for an existing cart item within the same order
        $existingCartItem = Cart::where('id_pemesanan', $order->id_pemesanan)
            ->where('id_produk', $request->id_produk)
            ->first();

        if ($existingCartItem) {
            // If the cart item exists, update its quantity and price
            $existingCartItem->jumlah += $request->jumlah;
            $existingCartItem->harga += $produk->harga_produk * $request->jumlah;
            $existingCartItem->save();
        } else {
            // If the cart item does not exist, create a new one
            Cart::create([
                'jumlah' => $request->jumlah,
                'id_produk' => $request->id_produk ?? null,
                'id_pemesanan' => $order->id_pemesanan,
                'id_hampers' => $request->id_hampers ?? null,
                'harga' => $produk->harga_produk * $request->jumlah
            ]);
        }

        // Calculate the total price of the order
        $cart_items = Cart::where('id_pemesanan', $order->id_pemesanan)->get();
        $total = 0;
        foreach ($cart_items as $item) {
            $total += $item->jumlah * $item->produk->harga_produk;
        }

        // Update the total price of the order
        $order->total = $total;
        $order->save();

        return redirect()->route('pemesanan', ['id' => $produk->id_produk])->with('success', 'Product added to cart successfully');
    }


    public function createPemesanan()
    {
        $user_id = Auth::id();

        // Retrieve the latest order with status 'belum dibayar'
        $last_order = Pemesanan::where('id_user', $user_id)
            ->where('status', 'belum dibayar')
            ->latest()
            ->first();

        // If there's no existing order with status 'belum dibayar', create a new one
        if (!$last_order) {
            $order = new Pemesanan();
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
            // If an existing order with 'belum dibayar' status exists, use it
            $order = $last_order;
        }

        // Return the latest or newly created order
        return $order;
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
            $Pemesanan->save();
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

        while ($PemesananTotal > 0) {
            if ($PemesananTotal >= 1000000) {
                $points += 200;
                $PemesananTotal -= 1000000;
            } elseif ($PemesananTotal >= 500000) {
                $points += 75;
                $PemesananTotal -= 500000;
            } elseif ($PemesananTotal >= 100000) {
                $points += 15;
                $PemesananTotal -= 100000;
            } elseif ($PemesananTotal >= 10000) {
                $points += 1;
                $PemesananTotal -= 10000;
            } else {
                break;
            }
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
}
