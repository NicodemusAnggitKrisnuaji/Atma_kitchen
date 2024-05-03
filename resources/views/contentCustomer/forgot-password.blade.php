
@extends('dashboard')

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
                min-height: 100vh;
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
            <div class="col-md-5 login-box">
                <h2 class="text-center">Forgot Password</h2>
                <br>
                <div class="form">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session()->has('status'))
                        <div class="alert alert-success">
                            {{ session()->get('status') }}
                        </div>
                    @endif
                </div>

                <form method="post" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label><b>Masukan Email</b></label>
                        <input class="form-control" type="email" name="email" id="email" placeholder="email" required>
                    </div>
                    <br>

                    <div>
                        <button type="submit" class="btn btn-primary btn-block" style="width: 100%; background-color: #FCC0C0; color: black;">Submit</button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
 @endsection