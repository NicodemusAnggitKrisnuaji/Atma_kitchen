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
        aling-items: center;
    }

    .form-check-input:checked+.custom-radio {
        background-color: #FCC0C0;
        border-color: #FCC0C0;
    }

    .form-check-input {
        display: none;
    }
</style>

<div class="container mt-5">
    <div class="row" style="margin-top: 100px;">
        <div class="col-md-8">
            <div class="d-flex mb-4">
                <div class="progress" style="height: 5px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="text-muted ms-2">
                    <span class="fw-bold" style="margin-right: 300px;">1. Cart</span>
                    <span class="text-secondary">2. Payment</span>
                </div>
            </div>

            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Items</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $cartItem)
                    <tr>
                        <td>
                            @if($cartItem->produk)
                            {{ $cartItem->produk->nama_produk }}<br>
                            @elseif($cartItem->hampers)
                            {{ $cartItem->hampers->nama_hampers}}
                            @else
                            Produk tidak ditemukan
                            @endif
                        </td>
                        <td class="align-middle">
                            <div class="d-flex align-items-center">
                                <form action="{{ url('cart.add') }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="id_cart" value="{{ $cartItem->id_pemesanan }}">
                                    <div class="d-flex align-items-center">
                                        <span>{{ $cartItem->jumlah }}</span>
                                    </div>
                                </form>
                            </div>
                        </td>
                        <td class="text-end">
                            @if($cartItem->produk)
                            Rp {{ number_format($cartItem->produk ? $cartItem->produk->harga_produk * $cartItem->jumlah : 0, 0, ',', '.') }}<br>
                            @elseif($cartItem->hampers)
                            Rp {{ number_format($cartItem->hampers ? $cartItem->hampers->harga * $cartItem->jumlah : 0, 0, ',', '.') }}
                            @else
                            terdapat kesalahan
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('cart.destroy', ['id' => $cartItem->id_cart]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link" style="padding: 0;"><i class="fa-solid fa-trash-can text-black"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-end">
                <p class="text-muted">Order Subtotal:</p>
                <p class="h5 ms-2">Rp {{ number_format($cartItems->sum(function($cartItem) {
                    if ($cartItem->produk) {
                        return $cartItem->produk->harga_produk * $cartItem->jumlah;
                    } elseif ($cartItem->hampers) {
                        return $cartItem->hampers->harga * $cartItem->jumlah;
                    } else {
                        return 0;
                    }
                }), 0, ',', '.') }}</p>
            </div>

            <form action="{{ route('updateDelivery', $cartItem->id_pemesanan) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="jenis_pengiriman" class="form-control select-center" onchange="this.form.submit()">
                    <option value="" disabled selected>Pilih Jenis Pengiriman</option>
                    <option value="delivery" {{ $cartItem->jenis_pengiriman == 'delivery' ? 'selected' : '' }}>Delivery</option>
                    <option value="pickup" {{ $cartItem->jenis_pengiriman == 'pickup' ? 'selected' : '' }}>Pickup</option>
                </select>
            </form>

            <div class="mt-4">
                <a href="{{ url('catalog') }}" style="color: black;">Continue to Shopping &gt;</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Order Summary
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p><strong>Total</strong></p>
                        <p class="h5 ms-2"><strong>Rp {{ number_format($cartItems->sum(function($cartItem) {
                            if ($cartItem->produk) {
                                return $cartItem->produk->harga_produk * $cartItem->jumlah;
                            } elseif ($cartItem->hampers) {
                                return $cartItem->hampers->harga * $cartItem->jumlah;
                            } else {
                                return 0;
                            }
                        }), 0, ',', '.') }}</strong></p>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <p>Point Yang Didapat:</p>
                        <p></p>
                    </div>
                </div>
                <div class="card-header">
                    Poin Payment
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <p>Poin Yang Dimiliki Saat Ini:</p>
                        <p>{{ Auth::user()->poin }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Tukar Poin:</p>
                        <div>
                            <input type="number" name="poin_tukar" id="poin_tukar" class="form-control" value="{{ Auth::user()->poin }}" min="0" required style="width: 100px; height: 30px;" oninput="updateTotal(this.value)">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Total Setelah Dipotong Poin:</p>
                        @php
                            $total = $cartItems->sum(function($cartItem) {
                                if ($cartItem->produk) {
                                    return $cartItem->produk->harga_produk * $cartItem->jumlah;
                                } elseif ($cartItem->hampers) {
                                    return $cartItem->hampers->harga * $cartItem->jumlah;
                                } else {
                                    return 0;
                                }
                            }); // Ganti 50000 dengan biaya pengiriman jika sesuai
                            $totalSetelahPotong = $total; // Inisialisasi nilai total setelah dipotong
                        @endphp
                        <p id="totalSetelahPotong">Rp {{ number_format($totalSetelahPotong, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('pembayaran') }}" class="btn btn-primary btn-block" style="margin-bottom: 10px; margin-left: 55px; background-color: #FCC0C0; color: black; width: 250px;">Continue to Payment</a>
                </div>

                <div class="mt-4 text-center">
                    <a href="{{ route('payment') }}" class="btn btn-primary btn-block" style="margin-bottom: 10px; margin-left: 55px; background-color: #FCC0C0; color: black; width: 250px;">Cetak Bukti Transaksi</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection