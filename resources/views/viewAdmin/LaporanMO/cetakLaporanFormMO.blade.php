@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cetak Laporan Keseluruhan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Cetak Laporan Keseluruhan</a>
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
                        <div class="input-group mb-3">
                            <label for="tahun">Tahun</label>
                            <input type="number" name="tahun" id="tahun" class="form-control" min="2000" max="{{ date('Y') }}" required />
                        </div>
                        <div class="input-group mb-3">
                            <a href="" onclick="this.href='/laporan/cetakLaporanTabelMO/'+ document.getElementById('tahun').value" target="_blank" class="btn btn-primary col-md-12">
                                Cetak Laporan Pertahun <i class="fas fa-print"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection