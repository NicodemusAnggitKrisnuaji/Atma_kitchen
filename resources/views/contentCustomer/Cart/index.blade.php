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
                                    <input type="text" name="quantity" value="{{ $cartItem->jumlah }}">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
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

            <div class="d-flex mt-4 justify-content-center">
                <div class="form-check me-3">
                    <input class="form-check-input" type="radio" name="delivery_option" id="delivery_option" value="delivery" checked>
                    <label class="form-check-label custom-radio" for="delivery_option">
                        <div class="custom-radio-content">
                            <i class="fa-solid fa-truck"></i>
                            <span>Delivery</span>
                        </div>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="delivery_option" id="pickup_option" value="pickup">
                    <label class="form-check-label custom-radio" for="pickup_option">
                        <div class="custom-radio-content">
                            <i class="fa-solid fa-store"></i>
                            <span>Pick Up</span>
                        </div>
                    </label>
                </div>
            </div>

            <div class="mt-4">
                <div id="delivery_address" class="d-none">
                    <label for="address">Delivery Address:</label>
                    <textarea class="form-control" id="address" rows="3"></textarea>
                </div>

                <div id="pickup_address" class="d-none">
                    <label for="pickup_address">Pick Up Address:</label>
                    <textarea class="form-control" id="pickup_address" rows="3"></textarea>
                </div>
            </div>

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
                        <p>Order Subtotal:</p>
                        <p>Rp {{ number_format($cartItems->sum(function($cartItem) {
                            return $cartItem->produk ? $cartItem->produk->harga * $cartItem->quantity : 0;
                        }), 0, ',', '.') }}</p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Delivery Fee:</p>
                        <p>Rp 50.000</p>
                    </div>
                    <div class="d-flex justify-content-between border-bottom">
                        <p><strong>Total:</strong></p>
                        <p><strong>Rp {{ number_format($cartItems->sum(function($cartItem) {
                            return $cartItem->produk ? $cartItem->produk->harga * $cartItem->quantity : 0;
                        }) + 50000, 0, ',', '.') }}</strong></p>
                    </div>
                </div>
                <div class="mt-4 text-center">
                    <a href="{{ route('pembayaran') }}" class="btn btn-primary btn-block" style="margin-bottom: 10px; margin-left: 55px; background-color: #FCC0C0; color: black; width: 250px;">Continue to Payment</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('input[name="delivery_option"]').change(function() {
            if ($(this).val() === 'delivery') {
                $('#delivery_address').removeClass('d-none');
                $('#pickup_address').addClass('d-none');
            } else {
                $('#delivery_address').addClass('d-none');
                $('#pickup_address').removeClass('d-none');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const deliveryOption = document.getElementById('delivery_option');
        const pickupOption = document.getElementById('pickup_option');

        function disableOtherOption() {
            if (this.checked) {
                if (this.id === 'delivery_option') {
                    pickupOption.disabled = true;
                } else if (this.id === 'pickup_option') {
                    deliveryOption.disabled = true;
                }
            }
        }

        function enableOtherOption() {
            if (this.id === 'delivery_option') {
                pickupOption.disabled = false;
            } else if (this.id === 'pickup_option') {
                deliveryOption.disabled = false;
            }
        }

        deliveryOption.addEventListener('change', disableOtherOption);
        deliveryOption.addEventListener('change', enableOtherOption);

        pickupOption.addEventListener('change', disableOtherOption);
        pickupOption.addEventListener('change', enableOtherOption);
    });
</script>

@endsection