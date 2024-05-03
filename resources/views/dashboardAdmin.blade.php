<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initialscale=1">
    <title>ATMA KITCHEN</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrapicons@1.18.0/font/bootstrap-icons.css">

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
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fa-solid fa-expand"></i>
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
                    </ul>
                </nav>
            </div>
            <div class="d-flex justify-content-center" style="position: absolute; bottom: 0; width: 100%;">
                <a href="{{ route('actionLogout') }}" class="btn btn-sm btn-danger">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </a>
            </div>
        </aside>
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

</body>

</html>