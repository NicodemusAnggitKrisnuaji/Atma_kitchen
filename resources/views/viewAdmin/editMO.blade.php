@extends('dashboardMO')

@section('title')
Situs Atma Kitchen
@endsection

@section('content')
<style>
    body {
        background-color: white;
        background-size: cover;
        background-position: center;
    }

    .center-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 120vh;
    }

    .login-box {
        background: #F0E9E9;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background-color: #FCC0C0;
        padding: 10px 20px;
        width: 100%;
        position: fixed;
        top: 0;
        height: 11vh;
    }

    .rounded {
        display: inline-block;
        width: 100px;
        height: 30px;
        border-radius: 8px;
        background-color: #F0F0F0;
        text-align: center;
        line-height: 30px;
        padding: 0 10px;
        margin-right: 10px;
    }

    .logo-link {
        display: inline-block;
        padding: 20px;
    }

    .logo {
        font-size: 30px;
        font-weight: bold;
        color: white;
        letter-spacing: 1px;
        height: auto;
        width: 100px;
        margin-top: -5px;
    }

    .nav-icons {
        display: flex;
        gap: 20px;
        justify-content: flex-end;
    }

    .nav-icons i {
        font-size: 20px;
        color: black;
        transition: transform 0.3s ease, color 0.3s ease;
    }
</style>



<div class="container center-container">
    <div class="col-md-5 login-box" style="margin-top: 100px; margin-bottom: 50px;">
        <h2 class="text-center">Edit Profile</h2>
        <br>

        @if (session('error'))
        <div class="alert alert-danger">
            <b>Oops!</b> {{ session('error') }}
        </div>
        @endif

        <form action="{{ route('updateProfileMO', ['id' => $user->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label><b>Nama</b></label>
                <input class="form-control" type="text" name="nama" id="nama" value="{{  old('nama', Auth::user()->nama) }}" required>
            </div>
            <br>

            <div class="form-group">
                <label><b>Email</b></label>
                <input class="form-control" type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required>
            </div>
            <br>

            <div class="form-group">
                <label><b>Password</b></label>
                <input class="form-control" type="password" name="password" id="password" value="">
            </div>
            <br>

            <div class="form-group">
                <label><b>Alamat</b></label>
                <input class="form-control" type="text" name="alamat" id="alamat" value="{{ old('alamat', Auth::user()->alamat) }}" required>
            </div>
            <br>

            <div class="form-group">
                <label><b>Nomor Telepon</b></label>
                <input class="form-control" type="text" name="nomor_telepon" id="nomor_telepon" value="{{ old('nomor_telepon', Auth::user()->nomor_telepon) }}" required>
            </div>
            <br>

            <div class="form-group">
                <label><b>Tanggal Lahir</b></label>
                <input class="form-control" type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir', Auth::user()->tanggal_lahir) }}" required>
            </div>
            <br>

            <div>
                <button type="submit" class="btn btn-primary btn-block" style="width: 40%; background-color: blue; color: white;">Save</button>
                <a href="{{ route('profileMO') }}" class="btn btn-primary btn-block" style="width: 40%; background-color: red; color: black; margin-left: 20px;">Cancel</a>
            </div>
            <br>
        </form>
    </div>
</div>
@endsection