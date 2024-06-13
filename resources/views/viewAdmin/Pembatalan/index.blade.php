@extends('dashboardAdmin')
@section('content')

<div class="content-header">
    <div class="contianer-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pembatalan Pesanan</h1>
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
                        @if ($latePayments->isEmpty())
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
                                    @foreach ($latePayments as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->user->nama }}</td>
                                        <td class="text-center">
                                            @foreach ($cart as $cartItem)
                                            {{ $cartItem }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{ $order->total }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('orders.latePaymentsUpdate', $order->id_pemesanan) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control select-center" onchange="this.form.submit()">
                                                    <option value="telat bayar" {{ $order->status == 'telat bayar' ? 'selected' : '' }} disabled>Telat Bayar</option>
                                                    <option value="batal" {{ $order->status == 'batal' ? 'selected' : '' }}>Batal</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $latePayments->links() }}
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