@extends('dashboardOwner')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Cetak Laporan Penjualan Bulanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">Cetak Laporan Penjualan Bulanan</a>
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
                        <form action="{{ route('laporan.penjualan-bulanan') }}" method="GET">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="month">Bulan</label>
                                </div>
                                <select name="month" id="month" class="form-control" required>
                                    <option value="">Pilih Bulan</option>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ \Carbon\Carbon::create()->month($i)->format('F') }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="year">Tahun</label>
                                </div>
                                <input type="number" name="year" id="year" class="form-control" min="2000" max="{{ date('Y') }}" required />
                            </div>

                            <div class="input-group mb-4">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Cetak Laporan Penjualan Bulanan <i class="fas fa-print"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection