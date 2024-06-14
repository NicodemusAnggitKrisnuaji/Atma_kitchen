<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initialscale=1">
    <title>ATMA KITCHEN</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        .custom-sidebar {
            background-color: #8B5D5D;
            color: #000000;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="background-color: #C19191;">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                        <i class="fa-solid fa-bars"></i>
                    </a>
                </li>
            </ul>
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="{{ route('actionLogout') }}" class="btn btn-sm btn-danger">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar custom-sidebar elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link d-flex justify-content-center">
                <img src="{{ asset('img/logo.png') }}" width="200" height="200" alt="AtmaKitchen Logo">
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('profileAdmin') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <p>Profile Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('produk') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <p>Produk</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('resep') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-clipboard-list"></i>
                                <p>Resep</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('bahanBaku') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-warehouse"></i>
                                <p>Bahan Baku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('hampers') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-gift"></i>
                                <p> Hampers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('searchCus') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-user"></i>
                                <p> Customer</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pengiriman') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-people-arrows"></i>
                                <p> Input Jarak Pengiriman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('tip') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-circle-check"></i>
                                <p> Konfirmasi Pembayaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('PenarikanSaldo') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-circle-check"></i>
                                <p> Konfirmasi Penarikan Saldo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('status') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-pen"></i>
                                <p> Update Status Pengiriman</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pembatalan') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-xmark"></i>
                                <p> Pembatalan Pesanan</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            @yield('content')
        </div>
        <br>
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #8B5D5D">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel" style="color: white;">Apakah Ingin Logout?</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal" style="border: 1px solid;">Close</button>
                        <a href="{{ route('actionLogout') }}" class="btn btn-sm btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

</body>

</html>