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
        <h1>Cakes</h1>
    </div>

    <div class="heading">
        <div class="row">
            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('detailKue/lapisLegit.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Lapis Legit</h3>
                        <p class="text-muted">Lapis legit, atau juga dikenal sebagai spekkoek, adalah sejenis... </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('detailKue/lapisSurabaya.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Lapis Surabaya</h3>
                        <p class="text-muted">Lapis Surabaya adalah sejenis kue tradisional Indonesia yang... </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('detailKue/brownies.jpeg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Brownies</h3>
                        <p class="text-muted">Brownies adalah sejenis kue yang sangat populer, terutama... </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('detailKue/mandarin.jpeg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Mandarin</h3>
                        <p class="text-muted">Kue mandarin adalah sejenis kue yang memiliki akar dalam... </p>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-3">
                <div class="card mb-4">
                    <a href="">
                        <img style="height: 300px; border-radius: 10px;" src="{{ asset('detailKue/spikoe.jpg') }}" class="card-img-top object-fit-cover" alt="Foto Kategori Cake">
                    </a>
                    <div class="card-body col-12">
                        <h3>Spikoe</h3>
                        <p class="text-muted">Spikoe, juga dikenal sebagai kue spiku atau lapis legit, adalah... </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection