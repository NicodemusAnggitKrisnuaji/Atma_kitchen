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

    .card {
        border-color: white;
    }
</style>

<div class="main">
    <div class="d-flex justify-content-center" style="margin-top: 100px;">
        <h1>Product</h1>
    </div>

    <div class="heading">
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
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/drinks.webp') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
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
        </div>
    </div>

    <div class="d-flex justify-content-center" style="margin-top: 30px;">
        <h1>Hampers</h1>
    </div>

    <div class="heading">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/hampersA.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    <div class="card-body col-12">
                        <h3>Paket Hampers A</h3>
                        <p class="text-muted">Paket Hampers yang berisi produk... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/hampersB.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    <div class="card-body col-12">
                        <h3>Paket Hampers B</h3>
                        <p class="text-muted">Paket Hampers yang berisi produk... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKategori/hampersC.webp') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    <div class="card-body col-12">
                        <h3>Paket Hampers C</h3>
                        <p class="text-muted">Paket Hampers yang berisi produk... </p>
                        <a href="#"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


