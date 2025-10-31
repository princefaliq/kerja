
<!doctype html>
<html class="no-js" lang="en">
<head>
    <title>Maintenance | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="description" content="Kerja Berkah adalah portal resmi di bawah Dinas Penanaman Modal, Pelayanan Terpadu Satu Pintu (DPMPTSP) dan Tenaga Kerja Kabupaten Bondowoso yang menyediakan informasi lowongan kerja terbaru, sistem pencarian kerja, serta layanan ketenagakerjaan untuk masyarakat Bondowoso." />
    <meta name="keywords" content="kerja berkah, lowongan kerja bondowoso, DPMPTSP Bondowoso, tenaga kerja bondowoso, portal kerja resmi, info loker bondowoso, pencarian kerja, pekerjaan terbaru bondowoso, karier bondowoso, dinas tenaga kerja bondowoso, sistem pencari kerja, lowongan pemerintah bondowoso" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="@yield('title') | {{ config('app.name') }}" />
    <meta property="og:url" content="https://kerja.bondowosokab.go.id" />
    <meta property="og:site_name" content="Kerja Berkah" />
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
</head>
<body>
<section class="cover-background full-screen ps-8 pe-8 sm-ps-6 sm-pe-6 overflow-auto" style="background-image: url(crafto/images/maintenance-bg.jpg);">
    <div class="container-fluid h-100">
        <div class="row align-items-center justify-content-center h-100">
            <div class="col-lg-6 col-xl-5 text-center text-lg-start md-mb-30px" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <a href="/" class="mb-12 md-mb-50px d-inline-block">
                    <img src="{{ url('logo/logo_kerja_berkah.png') }}" style="max-height: 80px" data-at2x="{{ url('logo/logo_kerja_berkah.png') }}" alt="">
                </a>
                <h2 class="text-white fw-600 mb-20px ls-minus-1px">Situs web sedang dalam pemeliharaan.</h2>
                <p class="text-white opacity-8 w-75 xl-w-100 mb-30px">Kami hampir menyelesaikan semua perbaikan teknis dan akan segera kembali. Terima kasih atas kesabaran Anda!</p>
                {{--<div class="d-inline-block w-100 newsletter-style-03 position-relative mb-7">
                    <form action="" method="post" class="position-relative w-70 xl-w-100">
                        <div class="position-relative">
                            <input class="input-large bg-white border-color-transparent w-100 border-radius-5px box-shadow-extra-large form-control required" type="email" name="email" placeholder="Enter your email address" />
                            <input type="hidden" name="redirect" value="">
                            <button class="btn btn-large text-dark-gray ls-0px text-transform-none left-icon submit fw-700" aria-label="submit"><i class="icon feather icon-feather-mail icon-small align-middle"></i><span>Notify me</span></button>
                        </div>
                        <div class="form-results border-radius-100px mt-15px p-15px fs-15 w-100 text-center d-none"></div>
                    </form>
                </div>--}}
                <div class="elements-social social-icon-style-08">
                    <ul class="small-icon light">
                        <li><a class="facebook" href="https://www.facebook.com/" target="_blank"><i class="fa-brands fa-facebook-f"></i></a></li>
                        <li><a class="dribbble" href="http://www.tiktok.com" target="_blank"><i class="fa-brands fa-tiktok"></i></a></li>
                        <li><a class="linkedin" href="http://www.x.com" target="_blank"><i class="fa-brands fa-x-twitter"></i></a></li>
                        <li><a class="instagram" href="http://www.instagram.com" target="_blank"><i class="fa-brands fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-8 col-lg-6 col-xl-7 text-center" data-anime='{ "el": "childs", "translateY": [0, 0], "opacity": [0,1], "duration": 1200, "delay": 150, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <img src="{{ url('logo/logo_kerja_berkah_kecil.png') }}" class="animation-float" style="max-height: 800px" alt="">
            </div>
        </div>
    </div>
</section>
<!-- javascript libraries -->
<script type="text/javascript" src="{{ url('crafto/js/jquery.js') }}"></script>
<script type="text/javascript" src="{{ url('crafto/js/vendors.min.js') }}"></script>
<script type="text/javascript" src="{{ url('crafto/js/main.js') }}"></script>

</body>
</html>
