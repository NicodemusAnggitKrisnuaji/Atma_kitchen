<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pemesanan;
use App\Models\bahanBaku;
use App\Models\PenggunaanBahanBaku;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanController extends Controller
{
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


