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
        <h1>Titipan</h1>
    </div>
    <div class="heading">
        <div class="row">
            @php
            $produkTidakTersedia = true;
            @endphp

            @forelse ($produk as $item)
            @if ($item->kategori == 'Titipan')
            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('pemesanan', $item->id_produk) }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKue/' . $item->image) }}" class="card-img-top object-fit-cover" alt="Foto Kategori Titipan">
                    </a>
                    <div class="card-body col-12">
                        <h3>{{ $item['nama_produk'] }}</h3>
                        <p class="text-muted">Starts from Rp. {{ number_format($item['harga_produk'], 0, ',', '.') }}</p>
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
                    Maaf, Tidak Ada Produk yang Tersedia Saat Ini
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection