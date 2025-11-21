
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="description" content="Kerja Berkah adalah portal resmi di bawah Dinas Penanaman Modal, Pelayanan Terpadu Satu Pintu (DPMPTSP) dan Tenaga Kerja Kabupaten Bondowoso yang menyediakan informasi lowongan kerja terbaru, sistem pencarian kerja, serta layanan ketenagakerjaan untuk masyarakat Bondowoso." />
    <meta name="keywords" content="kerja berkah, lowongan kerja bondowoso, DPMPTSP Bondowoso, tenaga kerja bondowoso, portal kerja resmi, info loker bondowoso, pencarian kerja, pekerjaan terbaru bondowoso, karier bondowoso, dinas tenaga kerja bondowoso, sistem pencari kerja, lowongan pemerintah bondowoso" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="@yield('title') | {{ config('app.name') }}" />
    <meta property="og:url" content="https://kerja.bondowosokab.go.id" />
    <meta property="og:site_name" content="Kerja Berkah" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon icon -->
    <link rel="shortcut icon" href="{{ url('logo/logo_kerja_berkah_kecil.png') }}">
    <link rel="apple-touch-icon" href="{{ url('logo/logo_kerja_berkah_kecil_57x57.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('logo/logo_kerja_berkah_kecil_72x72.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('logo/logo_kerja_berkah_kecil_114x114.png') }}">
    <!-- google fonts preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- style sheets and font icons  -->
    <link rel="stylesheet" href="{{ url('crafto/css/vendors.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('crafto/css/icon.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('crafto/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ url('crafto/css/responsive.css') }}"/>
    <link rel="stylesheet" href="{{ url('crafto/demos/conference/conference.css') }}" />

    <link href="https://fonts.googleapis.com/css2?family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Akaya+Kanadaka&family=Montserrat+Alternates:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <style>
        @media (max-width: 991px) { /* untuk layar mobile dan tablet */
            section.bg-dark-midnight-blue {
                padding-top: 100px !important; /* sesuaikan dengan tinggi menu kamu */
            }
        }
    </style>
    @stack('css')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7MSZZR7N74"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-7MSZZR7N74');
    </script>
</head>
<body data-mobile-nav-style="classic">
<!-- start header -->
<header>
    <!-- start navigation -->
    <nav class="navbar navbar-expand-lg header-transparent bg-transparent disable-fixed">
        <div class="container-fluid">
            <div class="col-auto col-lg-2 me-lg-0 me-auto">
                <a class="navbar-brand" href="/">
                    <img src="{{ url('logo/logo_kerja_berkah.png') }}" data-at2x="{{ url('logo/logo_kerja_berkah.png') }}" alt="" class="default-logo">
                    <img src="{{ url('logo/logo_kerja_berkah.png') }}" data-at2x="{{ url('logo/logo_kerja_berkah.png') }}" alt="" class="alt-logo">
                    <img src="{{ url('logo/logo_kerja_berkah_dark.png') }}" data-at2x="{{ url('logo/logo_kerja_berkah_dark.png') }}" alt="" class="mobile-logo">
                </a>
            </div>
            <div class="col-auto menu-order position-static">
                <button class="navbar-toggler float-start" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-label="Toggle navigation">
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                    <span class="navbar-toggler-line"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav alt-font ls-05px">
                        <li class="nav-item"><a href="/" class="nav-link">Beranda</a></li>
                        <li class="nav-item dropdown dropdown-with-icon">
                            <a href="#" class="nav-link">Link Terkait</a>
                            <i class="fa-solid fa-angle-down dropdown-toggle" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"></i>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <li>
                                    <a href="https://siapkerja.kemnaker.go.id/" target="_blank"><img src="{{ url('logo/siaker-logo-blue.svg') }}" width="200" alt="">
                                        <div class="submenu-icon-content">
                                            <span>Siap Kerja</span>
                                            <p>Kemnaker</p>
                                        </div>
                                    </a>
                                </li>
                                {{--<li>
                                    <a href="demo-conference-speaker-details.html"><img src="https://placehold.co/200x200" alt="">
                                        <div class="submenu-icon-content">
                                            <span>Jessica dover</span>
                                            <p>Geologist speakers</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="demo-conference-speaker-details.html"><img src="https://placehold.co/148x148" alt="">
                                        <div class="submenu-icon-content">
                                            <span>Matthew taylor</span>
                                            <p>Psychologist speakers</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="demo-conference-speaker-details.html"><img src="https://placehold.co/148x148" alt="">
                                        <div class="submenu-icon-content">
                                            <span>Rodney stratton</span>
                                            <p>Psychologist speakers</p>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="demo-conference-speakers.html" class="btn btn-dark-gray btn-round-edge btn-box-shadow align-self-center text-center text-white">View all speakers</a>
                                </li>--}}
                            </ul>
                        </li>
                        @guest
                            <li class="nav-item"><a href="{{ url('register') }}" class="nav-link">Daftar Pelamar</a></li>
                            <li class="nav-item"><a href="{{ route('register.perusahaan') }}" class="nav-link">Daftar Perusahaan</a></li>
                        @endguest
                        @auth
                            @role('User')
                                <li class="nav-item"><a href="{{ url('profile') }}" class="nav-link">Profile</a></li>
                                <li class="nav-item"><a href="{{ route('lamaran.saya') }}" class="nav-link">Lamaran</a></li>
                            @endrole
                        @endauth
                    </ul>

                </div>
            </div>
            <div class="col-auto col-lg-2 text-end xs-ps-0 xs-pe-0">
                <div class="header-icon">
                    <div class="header-button">
                        @guest
                            {{-- Tombol Registration --}}
                            <a href="{{ url('login') }}"
                               class="btn btn-small text-transform-none btn-transparent-white-light border-1 left-icon btn-rounded fw-500">
                                <i class="feather icon-feather-log-in d-none d-xl-inline-block"></i>
                                Login
                            </a>
                        @endguest

                        @auth
                            {{-- Tombol Logout --}}
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="btn btn-small text-transform-none btn-transparent-white-light border-1 left-icon btn-rounded fw-500">
                                    <i class="feather icon-feather-log-out d-none d-xl-inline-block"></i>
                                    Logout
                                </button>
                            </form>
                        @endauth
                            {{--<a href="{{ url('register') }}"
                               class="btn btn-small text-transform-none btn-transparent-white-light border-1 left-icon btn-rounded fw-500">
                                <i class="feather icon-feather-mail d-none d-xl-inline-block"></i>
                                Register
                            </a>--}}
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- end header -->
@yield('content')

<!-- start footer -->
<footer class="bg-dark-midnight-blue background-position-right-top background-no-repeat md-background-image-none" style="background-image: url({{ url('logo/demo-conference-about-bg.png') }})">
    <div class="container">
        <div class="row justify-content-center text-center text-sm-start">
            <!-- start footer column -->
            <div class="col-lg-3 col-sm-6 md-mb-35px">
                <span class="alt-font d-block text-white mb-10px fs-20"><i class="feather icon-feather-map-pin align-text-bottom icon-extra-medium text-base-color me-10px"></i>Job Fair 2025</span>
                <p class="w-80 lg-w-100 md-w-70 sm-w-90 xs-w-100 mb-5px">GOR PELITA, Jl. Letjen Sutarman, Kec. Bondowoso,</p>
                <a href="https://maps.app.goo.gl/kWuz7dLJzHrPp8PN9" target="_blank" class="text-decoration-line-bottom text-uppercase fs-15 alt-font fw-500">Get directions</a>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-lg-3 col-sm-6 md-mb-35px">
                <span class="alt-font d-block text-white mb-10px fs-20"><i class="feather icon-feather-phone-call align-text-bottom icon-extra-medium text-base-color me-10px"></i>Contact us</span>
                <a href="mailto:admin@bondowosokab.go.id">admin@bondowosokab.go.id</a><br>
                <a href="tel:0332423645" class="mb-5px d-inline-block">0332 - 423645</a><br>
                <a href="#" class="text-decoration-line-bottom text-uppercase fs-15 alt-font fw-500">Call to event</a>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-lg-3 col-sm-6 xs-mb-35px">
                <span class="alt-font d-block text-white mb-10px fs-20"><i class="feather icon-feather-home align-text-bottom icon-extra-medium text-base-color me-10px"></i>Kantor details</span>
                <p class="w-85 lg-w-100 md-w-70 sm-w-90 xs-w-100 mb-5px">Jl. Ahmad Yani No.137, Kec. Bondowoso,</p>
                <a href="https://maps.app.goo.gl/YpDq3XNK2DbYJ7cHA" target="_blank" class="text-decoration-line-bottom text-uppercase fs-15 alt-font fw-500">Lokasi Kantor</a>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-lg-3 col-sm-6">
                <span class="alt-font d-block text-white mb-10px fs-20"><i class="feather icon-feather-send align-text-bottom icon-extra-medium text-base-color me-10px"></i>Social Media</span>
                <p class="mb-25px sm-mb-20px">Don't miss this amazing events</p>
                <div class="d-inline-block w-100 newsletter-style-01 position-relative large-icon">
                        <a class="facebook m-4" href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                        <a class="twitter m-4" href="http://www.twitter.com" target="_blank"><i class="fa-brands fa-x-twitter"></i></a>
                        <a class="instagram m-4" href="http://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                        <a class="tiktok m-4" href="http://www.tiktok.com/" target="_blank"><i class="fa-brands fa-tiktok"></i></a>
                </div>
            </div>
            <!-- end footer column -->
        </div>
        <div class="row align-items-center pt-6 md-pt-50px">
            <!-- start footer column -->
            <div class="col-lg-3 col-sm-6 text-center text-sm-start">
                <a href="/" class="footer-logo d-inline-block"><img src="{{ url('logo/logo_kerja_berkah.png') }}" data-at2x="{{ url('logo/logo_kerja_berkah.png') }}" alt=""></a>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-lg-6 order-1 order-sm-3 order-lg-1 md-mt-15px">
                <ul class="footer-navbar alt-font text-center lh-normal">
                    <li class="nav-item"><a href="" class="nav-link">About event</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Speakers</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Schedule</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Gallery</a></li>
                    <li class="nav-item"><a href="" class="nav-link">Pricing</a></li>
                </ul>
            </div>
            <!-- end footer column -->
            <!-- start footer column -->
            <div class="col-lg-3 col-sm-6 order-3 order-sm-2 order-lg-3 text-center text-sm-end xs-mt-10px last-paragraph-no-margin">
                <p>&COPY; Copyright 2025 <a href="https://komifo.bondowosokab.go.id" target="_blank" class="text-decoration-line-bottom text-white">APTIKA</a></p>
            </div>
            <!-- end footer column -->
        </div>
    </div>
</footer>
<!-- end footer -->
<!-- start scroll progress -->
<div class="scroll-progress d-none d-xxl-block">
    <a href="#" class="scroll-top" aria-label="scroll">
        <span class="scroll-text">Scroll</span><span class="scroll-line"><span class="scroll-point"></span></span>
    </a>
</div>
<!-- end scroll progress -->
<!-- javascript libraries -->
<script type="text/javascript" src="{{ url('crafto/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ url('crafto/js/vendors.min.js') }}"></script>
<script type="text/javascript" src="{{ url('crafto/js/main.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@stack('js')
</body>
</html>
