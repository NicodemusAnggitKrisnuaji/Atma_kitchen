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
        <h1>Hampers</h1>
    </div>
    <div class="heading">
        <div class="row">
            @php
            $hampersTidakTersedia = true;
            $hampers = App\Models\Hampers::all();
            @endphp

            @forelse ($hampers as $item)
            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="{{ url('pemesanan', $item->id_hampers) }}">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('fotoKue/' . $item->image) }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>{{ $item['nama_hampers'] }}</h3>
                        <p class="text-muted">Starts from Rp. {{ number_format($item['harga'], 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @php
            $hampersTidakTersedia = false;
            @endphp
            @endif
            @empty
            @endforelse

            @if ($hampersTidakTersedia)
            <div class="col-12">
                <div class="alert alert-danger">
                    Maaf, Tidak Ada Hampers yang Tersedia Saat Ini
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection