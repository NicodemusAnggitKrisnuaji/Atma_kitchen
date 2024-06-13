@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cetak Laporan Bahan Baku</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Cetak Laporan Bahan Baku</a>
                    </li>
                    <li class="breadcrumb-item active">Index</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-inline">
                            <div class="form-group mb-3 mr-3">
                                <label for="tglawal" class="mr-2">Tanggal Awal:</label>
                                <input type="date" name="tglawal" id="tglawal" class="form-control" />
                            </div>
                            <div class="form-group mb-3 mr-3">
                                <label for="tglakhir" class="mr-2">Tanggal Akhir:</label>
                                <input type="date" name="tglakhir" id="tglakhir" class="form-control" />
                            </div>
                            <div class="form-group mb-3">
                                <a href="" onclick="this.href='/laporanBahanBaku/cetakLaporanBahanBakuTabelMO/' + document.getElementById('tglawal').value + '/' + document.getElementById('tglakhir').value" target="_blank" class="btn btn-primary">
                                    Cetak Laporan Pertanggal <i class="fas fa-print"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
