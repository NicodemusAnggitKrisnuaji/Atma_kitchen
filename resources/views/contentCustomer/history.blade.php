@extends('dashboard')

@section('title')
Profile: {{ Auth::user()->nama }}
@endsection

@section('content')
<style>
    .profile-container {
        margin-top: 50px;
    }

    .box {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 40px;
        margin-bottom: 1px;
        border-radius: 10px;
    }

    .box a {
        text-decoration: none;
        color: black;
    }
</style>

<div class="container profile-container">
    <div class="row">
        <div class="col-md-3">
            <div class="box">
                <h2><strong>Hi {{ Auth::user()->nama }}</strong></h2>
                <p><strong>My poin:</strong> 100</p>
                <a href="{{ url('OrderHistory') }}">
                    <div class="box">
                        <p style="margin-bottom: -1px;">Order History</p>
                    </div>
                </a>
                <a href="{{ url('profile') }}">
                    <div class="box" style="margin-top: 10px;">
                        <p style="margin-bottom: -1px;">Account</p>
                    </div>
                </a>
                <a href="{{ route('actionLogout') }}">
                    <div class="box" style="margin-top: 50px; background-color: red; text-align: center; padding: 10px;">
                        <p style="margin-bottom: 0; color: white;">Logout</p>
                    </div>
                </a>
            </div>

        </div>
        <div class="col-md-8">
            <div class="box">
                <h2>History</h2>
                <table class="table table-striped text-center">
                    <tr>
                        <td style="background-color: brown; color: white;">No</td>
                        <td style="background-color: brown; color: white;">Nama Produk</td>
                        <td style="background-color: brown; color: white;">Tanggal</td>
                        <td style="background-color: brown; color: white;">Harga</td>
                        <td style="background-color: brown; color: white;">Status</td>
                    </tr>
                    @php
                    $i = 1;
                    @endphp

                    @if($history->isEmpty())
                    <tr>
                        <td colspan="5">Masih kosong</td>
                    </tr>
                    @else
                    @foreach($history as $item)
                    <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $item['nama_produk'] }}</td>
                        <td>{{ $item['tanggal'] }}</td>
                        <td>{{ $item['harga'] }}</td>
                        <td>{{ $item['status'] }}</td>
                    </tr>
                    @endforeach
                    @endif
                </table>
            </div>
        </div>
    </div>
</div>

@endsection