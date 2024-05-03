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
<div class="main">
    <div>
        <img src="{{ asset('Img/tes.jpg') }}" class="img-fluid large-image" alt="Cafe">
    </div>

    <div class="d-flex justify-content-center">
        <img src="{{ asset('Img/logo.png') }}" class="img-fluid" alt="Cafe" style="max-width: 200px;">
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <img src="{{ asset('Img/gambar1.jpg') }}" class="img-fluid" alt="Cafe" style="max-width: 500px;">
            </div>
            <div class="col-md-4">
                <div class="d-flex justify-content-center">
                    <h1>Tentang Kami</h1>
                </div>
                <div class="text-center" style="font-size: 24px;">
                    <p>Atma Kitchen adalah sebuah usaha baru di bidang kuliner, yang dimiliki oleh Bu Margareth Atma Negara, seorang selebgram yang sangat
                        suka mencoba makanan yang sedang hits dimana menjual aneka kue premium, dan akan segera dibuka di Yogyakarta.</p>
                </div>

            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center" style="margin-top: 50px;">
        <h1>Product</h1>
    </div>

    <div class="heading">
        <h2 style="margin-top: 20px;">Pre Order</h2>
        <div class="row">
            @php
            $produkTidakTersedia = true;
            @endphp

            @forelse ($produk as $item)
            @if ($item['stock'] == 0 && $item['kategori'] != 'Lain-lain')
            <div class="col-12 col-md-3">
                <div class="card mb-4 shadow-sm">
                    <img style="height: 300px;" src="{{ asset('fotoKue/' . $item->image) }}" class="card-img-top object-fit-cover" alt="Foto Kue">
                    <div class="card-body col-12">
                        <h3>{{ $item['nama_produk'] }}</h3>
                        <p class="text-muted">Rp. {{ number_format($item['harga_produk'], 0, ',', '.') }}</p>
                        <a href="#" class="btn btn-primary btn-sm btn-block mb-2">Pesan</a>
                    </div>
                </div>
            </div>
            @php
            $produkTidakTersedia = false;
            @endphp
            @endif
            @empty
            @endforelse

            @if ($produkTidakTersedia)
            <div class="col-12">
                <div class="alert alert-danger">
                    Maaf, tidak ada produk yang tersedia saat ini.
                </div>
            </div>
            @endif
        </div>

        <h2 style="margin-top: 20px;">Ready Stock</h2>
        <div class="row">
            @forelse ($produk as $item)
            @if ($item['stock'] != 0)
            <div class="col-12 col-md-3">
                <div class="card mb-4 shadow-sm">
                    <img style="height: 300px;" src="{{ asset('fotoKue/' . $item->image) }}" class="card-img-top object-fit-cover" alt="Foto Kue">
                    <div class="card-body col-12">
                        <h3>{{ $item['nama_produk'] }}</h3>
                        <p class="text-muted">Rp. {{ number_format($item['harga_produk'], 0, ',', '.') }}</p>
                        <a href="#" class="btn btn-primary btn-sm btn-block mb-2">Pesan</a>
                    </div>
                </div>
            </div>
            @endif
            @empty
            <div class="alert alert-danger">
                mohon Bersabar yh guys
            </div>
            @endforelse
        </div>
    </div>


    @endsection