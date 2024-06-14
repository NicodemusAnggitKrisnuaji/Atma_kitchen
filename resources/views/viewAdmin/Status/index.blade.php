@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="contianer-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Update Status Pesanan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="">Admin</a>
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
                        @if ($statusIndex->isEmpty())
                        <div class="alert alert-danger">
                            Pesanan Tidak Ditemukan
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
                                    @foreach ($statusIndex as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->user->nama }}</td>
                                        <td class="text-center">
                                            @foreach ($cart as $cartItem)
                                            {{ $cartItem }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{ $order->total }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('orders.statusUpdate', $order->id_pemesanan) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control select-center" onchange="this.form.submit()">
                                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }} disabled>diproses</option>
                                                    <option value="siap di-pickup" {{ $order->status == 'siap di-pickup' ? 'selected' : '' }}>Siap di-pickup</option>
                                                    <option value="sedang dikirim kurir" {{ $order->status == 'sedang dikirim kurir' ? 'selected' : '' }}>Sedang dikirim kurir</option>
                                                    <option value="sudah di pickup" {{ $order->status == 'sudah di pickup' ? 'selected' : '' }}>Sudah dipickup</option>
                                                    <option value="diambil sendiri" {{ $order->status == 'diambil sendiri' ? 'selected' : '' }}>Diambil sendiri</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $statusIndex->links() }}
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