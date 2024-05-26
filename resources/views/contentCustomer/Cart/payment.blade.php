@extends('dashboard')
@section('content')

<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">

<style>
    .custom-radio {
        display: block;
        text-align: center;
        width: 120px;
        padding: 20px;
        border: 2px solid #ccc;
        border-radius: 10px;
        cursor: pointer;
        background-color: #fff;
        transition: background-color 0.3s, border-color 0.3s;
    }

    .custom-radio-content {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-check-input:checked+.custom-radio {
        background-color: #FCC0C0;
        border-color: #FCC0C0;
    }

    .form-check-input {
        display: none;
    }

    .progress-container {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .progress {
        flex-grow: 1;
        height: 5px;
    }

    .progress-text {
        margin-left: 15px;
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .table-container {
        background: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        padding: 20px;
    }

    .table thead th {
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody td {
        vertical-align: middle;
    }

    .alert {
        margin-top: 20px;
    }

    .continue-shopping {
        margin-top: 20px;
        text-align: right;
    }

    .back-to-cart {
        margin-top: 20px;
        text-align: left;
    }
</style>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="progress-container">
                <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="progress-text">
                    <span class="text-secondary">1. Cart</span>
                    <span class="fw-bold">2. Payment</span>
                </div>
            </div>

            <div class="table-container">
                <table class="table table-borderless">
                    <thead>
                        <tr class="text-center">
                            <th scope="col">Produk</th>
                            <th scope="col">Total</th>
                            <th scope="col">Bukti Transfer</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($Pemesanans->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">
                                <div class="alert alert-danger">
                                    Pesanan tidak ditemukan.
                                </div>
                            </td>
                        </tr>
                        @else
                        @foreach($Pemesanans as $order)
                        <tr>
                            <td>
                            @foreach ($cart as $cartItem)
                            {{ $cartItem }} <br>
                            @endforeach
                            </td>
                            <td class="text-center">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                @if($order->status == 'belum dibayar')
                                <form action="{{ url('butki/'.$order->id_pemesanan) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                        <input type="file" name="bukti" class="form-control">
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2">Kirim Bukti</button>
                                </form>
                                @else
                                Menunggu konfirmasi
                                @endif
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

            <div class="back-to-cart-continue-shopping">
                <div class="d-flex justify-content-between">
                    <div>
                        <a href="{{ url('cart') }}" style="color: black;">&lt; Back to Cart</a>
                    </div>
                    <div>
                        <a href="{{ url('catalog') }}" style="color: black;">Continue to Shopping &gt;</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
