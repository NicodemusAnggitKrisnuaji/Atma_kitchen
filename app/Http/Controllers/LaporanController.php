<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Produk;
use App\Models\Pemesanan;
use App\Models\bahanBaku;
use App\Models\PenggunaanBahanBaku;
use Dompdf\Dompdf;

class LaporanController extends Controller
{
    public function PresensiDanGaji(Request $request)
    {
        $month = $request->input('bulan', Carbon::now()->subMonth()->month); // Mengambil input dari dropdown bulan
        $year = $request->input('tahun', Carbon::now()->year); // Mengambil input dari dropdown tahun

        // Ambil data karyawan dengan presensi bulan sebelumnya
        $employees = Karyawan::with(['presensi' => function ($query) use ($month, $year) {
            $query->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
        }])->get();

        $bolos = [];
        $hadir = [];

        foreach ($employees as $employee) {
            
            $bolos[$employee->id_karyawan] = $employee->presensi->where('status', 'Bolos')->count();
            $hadir[$employee->id_karyawan] = $employee->presensi->where('status', 'Hadir')->count();
        }

        
        if ($request->input('download') === 'pdf') {
            $pdf = PDF::loadView('Laporan.pdfPresensiDanGaji', compact('employees', 'bolos', 'hadir', 'month', 'year'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('pdfPresensiDanGaji.pdf');
        }

        
        return view('Laporan.PresensiDanGaji', compact('employees', 'bolos', 'hadir', 'month', 'year'));
    }

    public function PemasukanDanPengeluaran(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $total_penjualan = DB::table('pemesanans')
            ->whereMonth('tanggal_ambil', $month)
            ->whereYear('tanggal_ambil', $year)
            ->sum('total_keseluruhan');

        $total_tip = DB::table('pemesanans')
            ->whereMonth('tanggal_ambil', $month)
            ->whereYear('tanggal_ambil', $year)
            ->sum('tip');

        $pengeluaran_items = DB::table('pencatatan_pengeluarans')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $total_pengeluaran = $pengeluaran_items->sum('harga');

        if ($request->input('download') === 'pdf') {
            $pdf = PDF::loadView('Laporan.pdfPemasukanDanPengeluaran', compact('total_penjualan', 'total_tip', 'pengeluaran_items', 'total_pengeluaran', 'month', 'year'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('pdfPemasukanDanPengeluaran.pdf');
        }

        return view('Laporan.PemasukanDanPengeluaran', compact('total_penjualan', 'total_tip', 'pengeluaran_items', 'total_pengeluaran', 'month', 'year'));
    }



    /**
     * Display the transaction recap report.
     *
     * @return \Illuminate\Http\Response
     */
    public function penitipRecap(Request $request)
    {
        // Ambil bulan dan tahun dari request atau gunakan bulan dan tahun saat ini
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
    
        // Ambil transaksi berdasarkan bulan dan tahun dengan join ke tabel produk dan penitip
        $Penitip = Cart::join('produks', 'carts.id_produk', '=', 'produks.id_produk')
            ->join('penitips', 'produks.id_penitip', '=', 'penitips.id_penitip')
            ->join('pemesanans', 'carts.id_pemesanan', '=', 'pemesanans.id_pemesanan')
            ->whereMonth('pemesanans.tanggal_ambil', $month)
            ->whereYear('pemesanans.tanggal_ambil', $year)
            ->select('pemesanans.*', 'produks.id_penitip', 'penitips.nama as penitip_nama', 'carts.jumlah as qty', 'produks.nama_produk', 'produks.harga_produk as harga_terjual')
            ->get()
            ->groupBy('id_penitip');
    
        $recap = [];
        foreach ($Penitip as $id_penitip => $transaksiPenitip) {
            $totalQty = 0;
            $totalHarga = 0;
            $transactions = [];
            $penitipNama = $transaksiPenitip[0]->penitip_nama;
    
            foreach ($transaksiPenitip as $transaksi) {
                $qty = $transaksi->qty;
                $hargaJual = $transaksi->harga_terjual;
                $total = $qty * $hargaJual;
                $komisi = $total * 0.20;
                $totalDiterima = $total - $komisi;
    
                $transactions[] = [
                    'nama_produk' => $transaksi->nama_produk,
                    'qty' => $qty,
                    'harga_jual' => $hargaJual,
                    'total' => $total,
                    'komisi' => $komisi,
                    'total_diterima' => $totalDiterima
                ];
    
                $totalQty += $qty;
                $totalHarga += $total;
            }
    
            $komisiTotal = $totalHarga * 0.20;
            $totalSetelahKomisi = $totalHarga - $komisiTotal;
    
            $recap[] = [
                'penitipId' => $id_penitip,
                'penitipNama' => $penitipNama,
                'transactions' => $transactions,
                'totalQty' => $totalQty,
                'totalHarga' => $totalHarga,
                'komisi' => $komisiTotal,
                'totalSetelahKomisi' => $totalSetelahKomisi
            ];
        }
    
        if ($request->input('download') === 'pdf') {
            $pdf = PDF::loadView('Laporan.pdfPenitipRecap', compact('recap', 'month', 'year'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('pdfPenitipRecap.pdf');
        }
    
        return view('Laporan.PenitipRecap', compact('recap', 'month', 'year'));
    }

    public function PresensiDanGajiOwner(Request $request)
    {
        $month = $request->input('bulan', Carbon::now()->subMonth()->month); // Mengambil input dari dropdown bulan
        $year = $request->input('tahun', Carbon::now()->year); // Mengambil input dari dropdown tahun

        // Ambil data karyawan dengan presensi bulan sebelumnya
        $employees = Karyawan::with(['presensi' => function ($query) use ($month, $year) {
            $query->whereMonth('tanggal', $month)->whereYear('tanggal', $year);
        }])->get();

        $bolos = [];
        $hadir = [];

        foreach ($employees as $employee) {
            // Menghitung jumlah bolos dan jumlah hadir untuk setiap karyawan
            $bolos[$employee->id_karyawan] = $employee->presensi->where('status', 'Bolos')->count();
            $hadir[$employee->id_karyawan] = $employee->presensi->where('status', 'Hadir')->count();
        }

        // Cek apakah request adalah untuk download PDF
        if ($request->input('download') === 'pdf') {
            $pdf = PDF::loadView('LaporanOwner.pdfPresensiDanGaji', compact('employees', 'bolos', 'hadir', 'month', 'year'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('pdfPresensiDanGaji.pdf');
        }

        // Jika bukan download PDF, maka tampilkan view biasa
        return view('LaporanOwner.PresensiDanGaji', compact('employees', 'bolos', 'hadir', 'month', 'year'));
    }

    public function PemasukanDanPengeluaranOwner(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        $total_penjualan = DB::table('pemesanans')
            ->whereMonth('tanggal_ambil', $month)
            ->whereYear('tanggal_ambil', $year)
            ->sum('total_keseluruhan');

        $total_tip = DB::table('pemesanans')
            ->whereMonth('tanggal_ambil', $month)
            ->whereYear('tanggal_ambil', $year)
            ->sum('tip');

        $pengeluaran_items = DB::table('pencatatan_pengeluarans')
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $total_pengeluaran = $pengeluaran_items->sum('harga');

        if ($request->input('download') === 'pdf') {
            $pdf = PDF::loadView('LaporanOwner.pdfPemasukanDanPengeluaran', compact('total_penjualan', 'total_tip', 'pengeluaran_items', 'total_pengeluaran', 'month', 'year'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('pdfPemasukanDanPengeluaran.pdf');
        }

        return view('LaporanOwner.PemasukanDanPengeluaran', compact('total_penjualan', 'total_tip', 'pengeluaran_items', 'total_pengeluaran', 'month', 'year'));
    }



    /**
     * Display the transaction recap report.
     *
     * @return \Illuminate\Http\Response
     */
    public function penitipRecapOwner(Request $request)
    {
        // Ambil bulan dan tahun dari request atau gunakan bulan dan tahun saat ini
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);
    
        // Ambil transaksi berdasarkan bulan dan tahun dengan join ke tabel produk dan penitip
        $Penitip = Cart::join('produks', 'carts.id_produk', '=', 'produks.id_produk')
            ->join('penitips', 'produks.id_penitip', '=', 'penitips.id_penitip')
            ->join('pemesanans', 'carts.id_pemesanan', '=', 'pemesanans.id_pemesanan')
            ->whereMonth('pemesanans.tanggal_ambil', $month)
            ->whereYear('pemesanans.tanggal_ambil', $year)
            ->select('pemesanans.*', 'produks.id_penitip', 'penitips.nama as penitip_nama', 'carts.jumlah as qty', 'produks.nama_produk', 'produks.harga_produk as harga_terjual')
            ->get()
            ->groupBy('id_penitip');
    
        $recap = [];
        foreach ($Penitip as $id_penitip => $transaksiPenitip) {
            $totalQty = 0;
            $totalHarga = 0;
            $transactions = [];
            $penitipNama = $transaksiPenitip[0]->penitip_nama;
    
            foreach ($transaksiPenitip as $transaksi) {
                $qty = $transaksi->qty;
                $hargaJual = $transaksi->harga_terjual;
                $total = $qty * $hargaJual;
                $komisi = $total * 0.20;
                $totalDiterima = $total - $komisi;
    
                $transactions[] = [
                    'nama_produk' => $transaksi->nama_produk,
                    'qty' => $qty,
                    'harga_jual' => $hargaJual,
                    'total' => $total,
                    'komisi' => $komisi,
                    'total_diterima' => $totalDiterima
                ];
    
                $totalQty += $qty;
                $totalHarga += $total;
            }
    
            $komisiTotal = $totalHarga * 0.20;
            $totalSetelahKomisi = $totalHarga - $komisiTotal;
    
            $recap[] = [
                'penitipId' => $id_penitip,
                'penitipNama' => $penitipNama,
                'transactions' => $transactions,
                'totalQty' => $totalQty,
                'totalHarga' => $totalHarga,
                'komisi' => $komisiTotal,
                'totalSetelahKomisi' => $totalSetelahKomisi
            ];
        }
    
        if ($request->input('download') === 'pdf') {
            $pdf = PDF::loadView('LaporanOwner.pdfPenitipRecap', compact('recap', 'month', 'year'))->setOptions(['defaultFont' => 'sans-serif']);
            return $pdf->download('pdfPenitipRecap.pdf');
        }
    
        return view('LaporanOwner.PenitipRecap', compact('recap', 'month', 'year'));
    }

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
                        $salesReport[$product->harga_produk]['total_pendapatan'] += $item->jumlah * $product->harga_produk;
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

    public function cetakLaporanPenjualanPertahun($tahun)
    {
        // Mengambil data berdasarkan bulan dan tahun
        $cetakTahun = Pemesanan::select(
            DB::raw('MONTH(tanggal_lunas) as bulan'),
            DB::raw('COUNT(*) as jumlah_transaksi'),
            DB::raw('SUM(total_keseluruhan) as total_uang')
        )
        ->whereYear('tanggal_lunas', $tahun)
        ->groupBy(DB::raw('MONTH(tanggal_lunas)'))
        ->orderBy(DB::raw('MONTH(tanggal_lunas)'))
        ->get();

        return view('viewAdmin.Laporan.cetakLaporanTabel', compact('cetakTahun', 'tahun'));
    }

    public function cetakLaporanPenjualanPertahunMO($tahun)
    {
        // Mengambil data berdasarkan bulan dan tahun
        $cetakTahun = Pemesanan::select(
            DB::raw('MONTH(tanggal_lunas) as bulan'),
            DB::raw('COUNT(*) as jumlah_transaksi'),
            DB::raw('SUM(total_keseluruhan) as total_uang')
        )
        ->whereYear('tanggal_lunas', $tahun)
        ->groupBy(DB::raw('MONTH(tanggal_lunas)'))
        ->orderBy(DB::raw('MONTH(tanggal_lunas)'))
        ->get();

        return view('viewAdmin.LaporanMO.cetakLaporanTabelMO', compact('cetakTahun', 'tahun'));
    }

    public function cetakLaporanBahanBaku($tglawal, $tglakhir)
    {
        $cetakPeriode = PenggunaanBahanBaku::whereBetween('tanggal_penggunaan', [$tglawal, $tglakhir])
                        ->latest()
                        ->get();
        
        return view('viewAdmin.Laporan.cetakLaporanBahanBakuTabel', compact('cetakPeriode', 'tglawal', 'tglakhir'));
    }

    public function cetakLaporanBahanBakuMO($tglawal, $tglakhir)
    {
        $cetakPeriode = PenggunaanBahanBaku::whereBetween('tanggal_penggunaan', [$tglawal, $tglakhir])
                        ->latest()
                        ->get();
        
        return view('viewAdmin.LaporanMO.cetakLaporanBahanBakuTabelMO', compact('cetakPeriode', 'tglawal', 'tglakhir'));
    }

    public function cetakForm()
    {
        return view('viewAdmin.Laporan.cetakLaporanForm');
    }

    public function cetakFormMO()
    {
        return view('viewAdmin.LaporanMO.cetakLaporanFormMO');
    }

    public function cetakFormBahanBaku()
    {
        return view('viewAdmin.Laporan.cetakLaporanBahanBakuForm');
    }

    public function cetakFormBahanBakuMO()
    {
        return view('viewAdmin.LaporanMO.cetakLaporanBahanBakuFormMO');
    }
    
}
