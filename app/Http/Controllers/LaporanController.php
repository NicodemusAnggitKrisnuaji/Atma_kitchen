<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Cart;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

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
    
}
