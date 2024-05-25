@extends('dashboard')

@section('title')
Situs Atma Kitchen
@endsection

@section('content')
<style>
    .large-image {
        width: 100%;
        max-height: 600px;
        object-fit: cover;
    }

    .main {
        margin-bottom: 30px;
    }

    .heading {
        margin-left: 140px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<div class="container">
    <div class="main">
        <div class="d-flex justify-content-center" style="margin-top: 100px;"></div>

        <div class="row">
            <div class="col-md-6">
                <img style="border-radius: 10px;" src="{{ asset('fotoKue/' . $produk->image) }}" class="img-fluid large-image" alt="Foto Detail Produk">
                <div class="mt-3 d-flex justify-content-center">
                    <img src="{{ asset('fotoKue/' . $produk->image) }}" class="img-thumbnail" style="width: 100px; margin-right: 10px;" alt="Thumbnail 1">
                    <img src="{{ asset('fotoKue/' . $produk->image) }}" class="img-thumbnail" style="width: 100px; margin-right: 10px;" alt="Thumbnail 2">
                </div>
            </div>
            <div class="col-md-6">
                <h3>{{ $produk->nama_produk }}</h3>
                <p>{{ $produk->deskripsi_produk }}</p>
                <p>To ensure product quality, please order for self pick-up or take-away.</p>
                <h4>Rp {{ number_format($produk->harga_produk, 0, ',', '.') }}</h4>

                <div>
                    <form action="{{ url('cart.add') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <div class="d-flex align-items-center">
                                <button type="button" class="btn btn-light" onclick="decreaseQuantity()">-</button>
                                <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" data-max="{{ $produk->stock }}" style="width: 60px; text-align: center;">
                                <button type="button" class="btn btn-light" onclick="increaseQuantity()">+</button>
                            </div>
                            <small>Stok Tersedia: {{ $produk->stock }}</small>
                        </div>

                        @if($produk->stock > 0)
                        @auth
                            <button type="button" class="btn btn-primary" onclick="addToCart()">Add to Cart</button>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-primary">Add to Cart</a>
                        @endauth
                        @else
                        @auth
                            <button type="button" class="btn btn-primary">Pre-Order</button>
                        @else
                            <a href="{{ url('login') }}" class="btn btn-primary">Pre-Order</a>
                        @endauth
                        @endif

                        <a href="{{ url('cart') }}" class="btn btn-danger">Buy Now</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function increaseQuantity() {
        let quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        let max = parseInt(quantityInput.getAttribute('data-max'));
        if (quantity < max) {
            quantityInput.value = quantity + 1;
        }
    }

    function decreaseQuantity() {
        let quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value);
        if (quantity > 1) {
            quantityInput.value = quantity - 1;
        }
    }

    function addToCart() {
        let product = {
            id: '{{ $produk->id }}',
            nama: '{{ $produk->nama_produk }}',
            harga: '{{ $produk->harga_produk }}',
            jumlah: parseInt(document.getElementById('quantity').value)
        };

        let cart = JSON.parse(localStorage.getItem('cart')) || [];
        let existingProduct = cart.find(item => item.id === product.id);

        if (existingProduct) {
            existingProduct.jumlah += product.jumlah;
        } else {
            cart.push(product);
        }

        localStorage.setItem('cart', JSON.stringify(cart));
        console.log('Product addded to cart!');
        toastr.success('Product added to cart!');
    }

    document.querySelector('.btn-danger').addEventListener('click', function () {
        addToCart();
        window.location.href = '{{ url('cart') }}';
    });
</script>
@endsection