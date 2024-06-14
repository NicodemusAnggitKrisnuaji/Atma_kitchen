<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="{{ asset('img/logo.png') }}" type="image/x-icon">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
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
            width: auto;
            height: 30px;
            border-radius: 8px;
            background-color: #f0f0f0;
            text-align: center;
            line-height: 30px;
            padding: 0 10px;
            margin-right: 10px;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        .container-content {
            flex-grow: 1;
        }

        .wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
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
            /* Memposisikan div ke kanan */
        }

        .nav-icons i {
            font-size: 20px;
            color: black;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        @media screen and (max-width: 576px) {
            .wrapper {
                width: 100%;
            }

            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background-color: #003366;
                padding: 10px 20px;
                width: 100%;
                position: fixed;
                top: 0;
                height: 8vh;
            }

            .logo {
                font-size: 5px;
                font-weight: bold;
                color: white;
                letter-spacing: 1px;
                height: auto;
                width: 70px;
                margin-left: -24px;
                margin-top: -10px;
            }

            .nav-icons {
                margin-top: -37px;
                margin-left: 300px;
            }

            .icon {
                width: 7px;
            }
        }
    </style>


</head>

<body>
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg fixed-top">
            <div class="container-fluid">

                <img src="{{ asset('Img/logo.png') }}" alt="Mobil Pilihan" class="logo">

                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('home') }}" style="font-size: 20px;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('catalog') }}" style="font-size: 20px;">Catalog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url ('penerimaan') }}" style="font-size: 20px;">Status</a>
                    </li>
                </ul>
                <div class="nav-icons">
                    <a href="{{ Auth::check() ? url('cart') : url('login') }}" class="icon">
                        <div class="rounded">
                            <span style="color: black;">Cart</span>
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                    </a>
                    <a href="{{ Auth::check() ? url('profile') : url('login') }}" class="icon">
                        <div class="rounded">
                            <span style="color: black;">{{ Auth::check() ? 'Profile' : 'Login' }}</span>
                            <i class="fas fa-user"></i>
                        </div>
                    </a>
                </div>
                
            </div>
        </nav>
        <div class="container-content">
            @yield('content')
        </div>

        <div class="container-fluid" style="background-color: #FCC0C0;">
            <div class="container py-4">
                <div class="row">
                    <div class="col-md-6 d-flex align-items-center">
                        <img src="{{ asset('img/logo.png') }}" alt="Mobil Pilihan" width="150" height="80">
                        <div class="ml-4">
                            <h4>Hubungi Kami</h4>
                            <p>Whatsapp: 089029988712</p>
                            <p>Email: AtmaKitchen@gmail.com</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex flex-column justify-content-between h-100">
                            <div>
                                <h5>Keep In Touch</h5>
                                <ul class="list-inline">
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-facebook"></i></a></li>
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                                    <li class="list-inline-item"><a href="#"><i class="fab fa-youtube"></i></a></li>
                                </ul>
                            </div>
                            <div>
                                <p>Alamat: Jl. Babarsari No.44, Janti, Caturtunggal, Kec. Depok,
                                    Kabupaten Sleman, Daerah Istimewa Yogyakarta 55281 </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</body>

</html>