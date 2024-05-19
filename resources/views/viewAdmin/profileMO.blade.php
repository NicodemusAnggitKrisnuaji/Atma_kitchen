@extends('dashboardMO')

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
        /* Menghilangkan garis bawah */
        color: black;
        /* Memberikan warna hitam */
    }
</style>

<div class="container profile-container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="box">
                <h2>Profile</h2>
                <div class="row">
                    <div class="col-md-3">
                        <p>Nama</p>
                        <p>Alamat</p>
                        <p>Email</p>
                        <p>Tanggal Lahir</p>
                        <p>Nomor Telepon</p>
                    </div>
                    <div class="col-md-1">
                        <p>: </p>
                        <p>: </p>
                        <p>: </p>
                        <p>: </p>
                        <p>: </p>
                    </div>
                    <div class="col-md-4" style="margin-left: -20px;">
                        <p>{{ Auth::user()->nama }}</p>
                        <p>{{ Auth::user()->alamat }}</p>
                        <p>{{ Auth::user()->email }}</p>
                        <p>{{ Auth::user()->tanggal_lahir }}</p>
                        <p>{{ Auth::user()->nomor_telepon }}</p>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-2">
                        <form action="{{ route('editProfileMO', ['id' => Auth::user()->id]) }}" method="GET">
                            @csrf
                            <button type="submit" class="btn btn-primary">Edit Profile</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection