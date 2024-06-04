@extends('dashboardMO')
@section('content')

<div class="content-header">
    <div class="contianer-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Pesanan Yang Perlu Diproses</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="">MO</a>
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
                        @if ($acceptedOrders->isEmpty())
                        <div class="alert alert-danger">
                            Pesanan Tidak Ditemukan
                        </div>
                        @else
                        <div class="table-responsive p-0 mt-3">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nama Cuastomer</th>
                                        <th class="text-center">Produk</th>
                                        <th class="text-center">Total Harga</th>
                                        <th class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($acceptedOrders as $order)
                                    <tr>
                                        <td class="text-center">{{ $order->user->nama }}</td>
                                        <td class="text-center">
                                            @foreach ($cart as $cartItem)
                                            {{ $cartItem }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-center">{{ $order->total }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('orders.acceptedUpdate', $order->id_pemesanan) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control select-center" onchange="this.form.submit()">
                                                    <option value="diterima" {{ $order->status == 'diterima' ? 'selected' : '' }} disabled>Diterima</option>
                                                    <option value="diproses" {{ $order->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                                    <option value="belum dapat diproses" {{ $order->status == 'belum dapat diproses' ? 'selected' : '' }}>Belum Dapat Diproses</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $acceptedOrders->links() }}
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