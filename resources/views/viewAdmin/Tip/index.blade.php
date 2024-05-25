@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Konfirmasi Pembayaran</h1>
            </div>

            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ url('tip')}}">Konfirmasi Pembayaran</a>
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
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <a href="{{ route('tip.create') }}" class="btn btn-md btn-success mb-4">Tambah Jumlah Pembayaran</a>
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-no-wrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Data Pemesanan</th>
                                        <th class="text-center">Total Pembayaran</th>
                                        <th class="text-center">Jumlah Yang Dibayar</th>
                                        <th class="text-center">Tip</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tip as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ strval($item->pemesanan->id_pemesanan) }}
                                        </td>
                                        <td class="text-center">
                                            {{$item->total }}
                                        </td>
                                        <td class="text-center">
                                            {{$item->jumlah }}
                                        </td>
                                        <td class="text-center">
                                            {{ $item->hasil_tip }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada pembayaran</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        {{ $tip->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
