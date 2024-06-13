@extends('dashboardMO')
@section('content')

<style>
    .select-center {
        text-align: center;
        text-align-last: center;
    }
</style>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Bahan Baku yang Dipakai</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="#">MO</a>
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama Bahan Baku</th>
                                    <th>Jumlah yang Digunakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($materialUsage as $material => $amount)
                                    <tr>
                                        <td>{{ $material }}</td>
                                        <td>{{ $amount }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection