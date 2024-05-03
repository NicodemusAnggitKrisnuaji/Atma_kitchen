@extends('dashboard')

@section('title')
Situs Atma Kitchen
@endsection

@section('content')
<div class="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <img src="{{ asset('Img/gambar1.jpg') }}" class="img-fluid" alt="Cafe" style="max-width: 400px;">
            </div>
            <div class="col-md-4">
                <h1 class="heading">Tentang Kami</h1>
                <p class="heading">Atma Kitchen adalah sebuah usaha baru di bidang kuliner, yang dimiliki oleh Bu Margareth Atma Negara, seorang selebgram yang sangat
                    suka mencoba makanan yang sedang hits dimana menjual aneka kue premium, dan akan segera dibuka di Yogyakarta.</p>
                <div class="box">
                    <div class="d-flex justify-content-between align-items-center">
                        <button onclick="decrement()">-</button>
                        <div id="value">0</div>
                        <button onclick="increment()">+</button>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="box">
                    <div class="d-flex justify-content-between align-items-center">
                        <button onclick="decrement()">-</button>
                        <div id="value">0</div>
                        <button onclick="increment()">+</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .main {
        margin-top: 100px;
        margin-bottom: 100px;
    }

    .heading {
        margin-top: 20px;
    }

    .box {
        text-align: center;
        margin-top: 30px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    #value {
        font-size: 24px;
    }

    button {
        padding: 8px 15px;
        font-size: 16px;
        margin: 0 5px;
    }
</style>

<script>
    let counter = 0;
    const valueElement = document.getElementById('value');

    function updateDisplay() {
        valueElement.innerText = counter;
    }

    function increment() {
        counter++;
        updateDisplay();
    }

    function decrement() {
        if (counter > 0) {
            counter--;
            updateDisplay();
        }
    }
</script>

@endsection
