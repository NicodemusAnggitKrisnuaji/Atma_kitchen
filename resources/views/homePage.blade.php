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

    <div class="heading" style="margin-top: 30px;">
        <div class="d-flex justify content center">
            <h2>Produk</h2>
        </div>
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('detailCake') }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/cakes.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Cake</h3>
                        <p class="text-muted">Kue adalah jenis makanan yang dibuat dengan menggunakan... </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('detailRoti') }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/breads.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Roti</h3>
                        <p class="text-muted">Roti adalah makanan pokok yang dibuat dari adonan tepung, air... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('detailMinuman') }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/drinks.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Minuman</h3>
                        <p class="text-muted">Minuman adalah cairan yang dikonsumsi oleh manusia dan makhluk... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('detailTitipan') }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/foods.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Titipan</h3>
                        <p class="text-muted">Titipan adalah suatu barang atau objek yang diberikan oleh satu pihak... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('detailHampers') }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/hampers.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Paket Hampers </h3>
                        <p class="text-muted">Paket Hampers yang berisi produk... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection