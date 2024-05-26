@extends('dashboardMO')
@section('content')

<style>
    .select-center {
        text-align: center;
        text-align-last: center;
        /* Untuk browser yang mendukung */
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Daftar Bahan Baku yang Perlu Dibeli</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">MO</a>
                    </li>
                    <li class="breadcrumb-item active">Bahan Baku Kurang</li>
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
                        @if (empty($requiredMaterials))
                        <div class="alert alert-success mt-3">
                            Semua bahan baku tersedia.
                        </div>
                        @else
                        <div class="table-responsive p-0 mt-3">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Bahan Baku</th>
                                        <th class="text-center">Jumlah yang Perlu Dibeli</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requiredMaterials as $material => $quantity)
                                    <tr>
                                        <td class="text-center">{{ $material }}</td>
                                        <td class="text-center">{{ $quantity }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
