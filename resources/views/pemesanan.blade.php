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
                                <input type="hidden" id="id_produk" name="id_produk" value="{{ $produk->id_produk }}">
                                <input type="hidden" id="harga_produk" name="harga_produk" value="{{ $produk->harga_produk }}">
                                <input type="text" id="jumlah" name="jumlah" class="form-control" value="1" data-max="{{ $produk->stock }}" style="width: 60px; text-align: center;">
                            </div>
                            <small>Stok Tersedia: {{ $produk->stock }}</small>
                        </div>

                        @if($produk->stock > 0)
                        <input type="hidden" name="harga_produk" value="{{ $produk->harga_produk }}">
                        <button type="submit" class="btn btn-primary">Add to Cart</button>
                        @else
                        <input type="hidden" name="harga_produk" value="{{ $produk->harga_produk }}">
                        <button type="button" class="btn btn-primary">Pre-Order</button>
                        @endif

                        <a href="{{ url('cart') }}" class="btn btn-danger">Buy Now</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
