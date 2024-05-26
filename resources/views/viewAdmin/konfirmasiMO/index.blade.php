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
                <h1 class="m-0">Konfirmasi Pesanan Customer</h1>
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
                        @if ($Pemesanans->isEmpty())
                        <div class="alert alert-danger mt-3">
                            Pesanan tidak ditemukan.
                        </div>
                        @else
                        <div class="table-responsive p-0 mt-3">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Customer</th>
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Pemesanans as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->user->nama }}</td>
                                        <td class="text-center">
                                            @foreach ($cart as $cartItem)
                                            {{ $cartItem }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{ $order->total }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('orders.update', $order->id_pemesanan) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control select-center" onchange="this.form.submit()">
                                                    <option value="pembayaran valid" {{ $order->status == 'pembayaran valid' ? 'selected' : '' }} disabled>pembayaran valid</option>
                                                    <option value="diterima" {{ $order->status == 'diterima' ? 'selected' : '' }}>Diterima</option>
                                                    <option value="ditolak" {{ $order->status == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $Pemesanans->links() }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
    <div id="errorAlert" class="alert alert-danger mt-3">
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div id="successAlert" class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif
</div>
@endsection