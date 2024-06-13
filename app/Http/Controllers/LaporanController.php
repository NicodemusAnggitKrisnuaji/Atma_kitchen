<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\bahanBaku;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Dompdf\Dompdf;

class LaporanController extends Controller
{
    public function LaporanPenjualanBulananPerProdukOwner(Request $request) 
    {
        $year = $request->input('year');
        $month = $request->input('month');

        $completedOrders = Pemesanan::whereYear('tanggal_lunas', $year)
            ->whereMonth('tanggal_lunas', $month)
            ->where('status', 'selesai')
            ->get();

        $salesReport = [];

        foreach ($completedOrders as $order) {
            $cartItems = Cart::where('id_pemesanan', $order->id_pemesanan)->get();

            foreach ($cartItems as $item) {
                if ($item->id_produk !== null) {
                    $product = Produk::find($item->id_produk);

                    if ($product) {
                        if (!isset($salesReport[$product->nama_produk])) {
                            $salesReport[$product->nama_produk] = [
                                'jumlah_terjual' => 0,
                                'total_pendapatan' => 0,
                            ];
                        }

                        $salesReport[$product->nama_produk]['jumlah_terjual'] += $item->jumlah;
                        $salesReport[$product->nama_produk]['total_pendapatan'] += $item->jumlah * $product->harga_produk;
                    }
                }
            }
        }

        uasort($salesReport, function($a, $b) {
            return $b['jumlah_terjual'] <=> $a['jumlah_terjual'];
        });

        return view('viewAdmin.LaporanPenjualanBulananPerProdukOwner.form', compact('salesReport', 'month', 'year'));
    }


    public function LaporanPenjualanBulananPerProdukMO(Request $request) 
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $completedOrders = Pemesanan::whereYear('tanggal_lunas', $year)
            ->whereMonth('tanggal_lunas', $month)
            ->where('status', 'selesai')
            ->get();

        $salesReport = [];

        foreach ($completedOrders as $order) {
            $cartItems = Cart::where('id_pemesanan', $order->id_pemesanan)->get();

            foreach ($cartItems as $item) {
                if ($item->id_produk !== null) {
                    $product = Produk::find($item->id_produk);

                    if ($product) {
                        if (!isset($salesReport[$product->nama_produk])) {
                            $salesReport[$product->nama_produk] = [
                                'jumlah_terjual' => 0,
                                'total_pendapatan' => 0,
                            ];
                        }

                        $salesReport[$product->nama_produk]['jumlah_terjual'] += $item->jumlah;
                        $salesReport[$product->nama_produk]['total_pendapatan'] += $item->jumlah * $product->harga_produk;
                    }
                }
            }
        }

        uasort($salesReport, function($a, $b) {
            return $b['jumlah_terjual'] <=> $a['jumlah_terjual'];
        });

        return view('viewAdmin.LaporanPenjualanBulananPerProdukMO.form', compact('salesReport', 'month', 'year'));
    }

    public function cetakLaporanBulananOwner()
    {
        return view('viewAdmin.LaporanPenjualanBulananPerProdukOwner.inputBulan');
    }

    public function cetakLaporanBulananMO()
    {
        return view('viewAdmin.LaporanPenjualanBulananPerProdukMO.inputBulan');
    }

    public function generatePDFLaporanPenjualanOwner(Request $request)
    {
        $month = $request->input('bulan');
        $year = $request->input('tahun');

        $completedOrders = Pemesanan::whereYear('tanggal_lunas', $year)
            ->whereMonth('tanggal_lunas', $month)
            ->where('status', 'selesai')
            ->get();

        $salesReport = [];

        foreach ($completedOrders as $order) {
            $cartItems = Cart::where('id_pemesanan', $order->id_pemesanan)->get();

            foreach ($cartItems as $item) {
                if ($item->id_produk !== null) {
                    $product = Produk::find($item->id_produk);

                    if ($product) {
                        if (!isset($salesReport[$product->nama_produk])) {
                            $salesReport[$product->nama_produk] = [
                                'jumlah_terjual' => 0,
                                'total_pendapatan' => 0,
                            ];
                        }

                        $salesReport[$product->nama_produk]['jumlah_terjual'] += $item->jumlah;
                        $salesReport[$product->nama_produk]['total_pendapatan'] += $item->jumlah * $product->harga_produk;
                    }
                }
            }
        }

        uasort($salesReport, function($a, $b) {
            return $b['jumlah_terjual'] <=> $a['jumlah_terjual'];
        });

        $pdf = new Dompdf();
        $pdf->loadHtml(view('viewAdmin.LaporanPenjualanBulananPerProdukOwner.pdf', compact('salesReport', 'month', 'year')));

        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        return $pdf->stream('laporan_penjualan_bulanan.pdf');
    }

    public function generatePDFLaporanPenjualanMO(Request $request)
    {
        $month = $request->input('bulan');
        $year = $request->input('tahun');

        $completedOrders = Pemesanan::whereYear('tanggal_lunas', $year)
            ->whereMonth('tanggal_lunas', $month)
            ->where('status', 'selesai')
            ->get();

        $salesReport = [];

        foreach ($completedOrders as $order) {
            $cartItems = Cart::where('id_pemesanan', $order->id_pemesanan)->get();

            foreach ($cartItems as $item) {
                if ($item->id_produk !== null) {
                    $product = Produk::find($item->id_produk);

                    if ($product) {
                        if (!isset($salesReport[$product->nama_produk])) {
                            $salesReport[$product->nama_produk] = [
                                'jumlah_terjual' => 0,
                                'total_pendapatan' => 0,
                            ];
                        }

                        $salesReport[$product->nama_produk]['jumlah_terjual'] += $item->jumlah;
                        $salesReport[$product->nama_produk]['total_pendapatan'] += $item->jumlah * $product->harga_produk;
                    }
                }
            }
        }

        uasort($salesReport, function($a, $b) {
            return $b['jumlah_terjual'] <=> $a['jumlah_terjual'];
        });

        $pdf = new Dompdf();
        $pdf->loadHtml(view('viewAdmin.LaporanPenjualanBulananPerProdukMO.pdf', compact('salesReport', 'month', 'year')));

        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        return $pdf->stream('laporan_penjualan_bulanan.pdf');
    }

    public function cetakLaporanStokBahanBakuOwner()
    {
        $bahanBakus = bahanBaku::all();

        return view('viewAdmin.LaporanStokBahanBakuOwner.form', compact('bahanBakus'));
    }

    public function generatePDFLaporanStokBahanBakuOwner()
    {
        $tanggalCetak = Carbon::now()->format('d F Y');
        $bahanBakus = bahanBaku::all();

        $pdf = new Dompdf();
        $pdf->loadHtml(view('viewAdmin.LaporanStokBahanBakuOwner.pdf', compact('bahanBakus', 'tanggalCetak')));

        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        return $pdf->stream('laporan_stok_bahan_baku.pdf');
    }

    public function cetakLaporanStokBahanBakuMO()
    {
        $bahanBakus = bahanBaku::all();

        return view('viewAdmin.LaporanStokBahanBakuMO.form', compact('bahanBakus'));
    }

    public function generatePDFLaporanStokBahanBakuMO()
    {
        $tanggalCetak = Carbon::now()->format('d F Y');
        $bahanBakus = bahanBaku::all();

        $pdf = new Dompdf();
        $pdf->loadHtml(view('viewAdmin.LaporanStokBahanBakuMO.pdf', compact('bahanBakus', 'tanggalCetak')));

        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        return $pdf->stream('laporan_stok_bahan_baku.pdf');
    }

}
