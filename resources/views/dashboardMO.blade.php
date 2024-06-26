<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initialscale=1">
    <title>Kelola Data Karyawan</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <!-- Boostrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
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
        <aside class="main-sidebar custom-sidebar elevation-10">
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
                            <a href="{{ url('profileMO') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-basket-shopping"></i>
                                <p>Profile MO</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('karyawan') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-user"></i>
                                <p> Karyawan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('penitip') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-box"></i>
                                <p> Penitip</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pembelian') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-cart-shopping"></i>
                                <p> Pembelian</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('pencatatan') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-comments-dollar"></i>
                                <p> Pengeluaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('orders') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-comments-dollar"></i>
                                <p> Konfirmasi Pesanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('PresensiDanGaji') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-comments-dollar"></i>
                                <p> Laporan Presensi Dan Gaji</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('PemasukanDanPengeluaran') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-comments-dollar"></i>
                                <p> Laporan Pemasukan Dan Pengeluaran</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('PenitipRecap') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-comments-dollar"></i>
                                <p> Laporan Penitip</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('accepted') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-table-list"></i>
                                <p> Pesanan Diproses</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('material.usage') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-table-list"></i>
                                <p> Bahan Baku Digunakan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('laporanMO') }}" class="nav-link" style="color:white;">
                                <i class="fa-solid fa-file"></i>
                                <p> Laporan Penjualan Bulanan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('laporanStokBahanBakuMO') }}" class="nav-link" style="color:white;">
                                <i class="fa-solid fa-file"></i>
                                <p> Laporan Stok Bahan Baku</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('laporanMO') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-file"></i>
                                <p> Cetak Laporan Penjualan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('laporanBahanBakuMO') }}" class="nav-link" style="color: white;">
                                <i class="fa-solid fa-file"></i>
                                <p> Cetak Laporan Penggunaan Bahan Baku</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->

        </aside>
        <!-- Content Wrapper. Contains page content -->
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
        <!-- /.content-wrapper -->
    </div>
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>

</body>

</html>