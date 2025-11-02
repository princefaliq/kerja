@extends('crafto.master')
@section('title','Lowongan Kerja')
@push('css')
    <style>
        .card-custom {
            min-height: 500px;  /* minimal tinggi */
            max-height: 500px;  /* batas maksimal */
            min-height: 500px;
        }
        .bidang-pekerjaan {
            display: block;
            line-height: 1.3em;     /* tinggi per baris */
            min-height: 2.6em;      /* 2 baris tetap (1.3 * 2) */
            overflow: hidden;       /* cegah tinggi berlebih */
            text-overflow: ellipsis; /* opsional, untuk potong teks panjang */
        }

    </style>
    {{-- RESPONSIVE CSS --}}
    <style>
        .pagination-wrapper {
            width: 100%;
            flex-wrap: wrap;
        }

        /* Default: tampilkan versi desktop */
        .pagination-desktop {
            display: flex;
            gap: 4px;
        }

        .pagination-mobile {
            display: none !important;
        }

        /* MOBILE MODE */
        @media (max-width: 576px) {
            .pagination-desktop {
                display: none !important;
            }

            .pagination-mobile {
                display: flex !important;
            }

            .pagination .page-link {
                font-size: 13px;
                padding: 6px 10px;
            }

            .pagination {
                flex-wrap: nowrap;
                justify-content: center;
                overflow-x: hidden;
            }
        }
    </style>
@endpush
@section('content')
    <section class="bg-dark-midnight-blue text-light pt-10 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-10 col-lg-9 pe-5 md-pe-15px md-mb-60px">
                    @if ($lowongans->isEmpty())
                        <p>Tidak ada lowongan yang tersedia saat ini.</p>
                    @else
                        <ul class="shop-modern shop-wrapper grid-loading grid grid-4col xl-grid-3col sm-grid-2col xs-grid-1col gutter-extra-large text-center" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                        <li class="grid-sizer"></li>
                        @foreach ($lowongans as $lowongan)
                            <li class="grid-item">
                                <div class="shop-box mb-10px">
                                    <div class="shop-image mb-20px">
                                        <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}">
                                            <div class="card card-custom bg-base-color shadow-sm border-0">
                                                <div class="card-body">
                                                    <div class="row text-start text-light">
                                                        <div class="col-12 text-center mt-20">
                                                            <img src="{{ $lowongan->user->avatar_url ? asset($lowongan->user->avatar_url) : 'https://placehold.co/58x58' }}" alt="{{ $lowongan->user->name }}" class="img-fluid" style="width:60px; height:60px">
                                                        </div>
                                                        <div class="col-12 text-center">
                                                            <p class="mb-10px"> {{ Str::limit($lowongan->judul, 20, '...') }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p class="mb-10px">Lokasi : {{ Str::limit($lowongan->lokasi, 20, '...') }}</p>
                                                        </div>
                                                        {{--<div class="col-12">
                                                            <p class="mb-10px">Rentang Gaji : {{ $lowongan->rentang_gaji }}</p>
                                                        </div>--}}
                                                        <div class="col-12">
                                                            <p class="mb-10px">Pendidikan min : {{ $lowongan->pendidikan_minimal }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p class="mb-10px">Jenis Kelamin : {{ $lowongan->jenis_kelamin }}</p>
                                                        </div>
                                                        <div class="col-12">
                                                            <p class="mb-10px">Batas lamaran : {{ $lowongan->batas_lamaran ? $lowongan->batas_lamaran->diffForHumans() : '-' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <span class="lable bg-golden-yellow">{{ $lowongan->user->name }}</span>
                                            <div class="shop-overlay bg-gradient-white-transparent"></div>
                                        </a>
                                        <div class="shop-buttons-wrap">
                                            <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="alt-font btn btn-small btn-box-shadow btn-white btn-round-edge left-icon add-to-cart">
                                                <i class="feather icon-feather-file"></i><span class="quick-view-text button-text">Lamar</span>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="shop-footer text-center">
                                        <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="alt-font text-light fs-19 fw-500 bidang-pekerjaan text-capitalize">{{ $lowongan->bidang_pekerjaan }}</a>
                                        <div class="price lh-22 fs-16 text-capitalize bidang-pekerjaan">{{ $lowongan->jenis_pekerjaan }}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                    @endif
                    <div class="w-100 d-flex mt-4 justify-content-center md-mt-30px">
                        @if ($lowongans->hasPages())
                            {{-- Pagination wrapper --}}
                            <div class="pagination-wrapper d-flex justify-content-center">

                                {{-- DESKTOP PAGINATION --}}
                                <ul class="pagination pagination-desktop pagination-style-01 fs-13 fw-500 mb-0 justify-content-center">

                                    {{-- Tombol Previous --}}
                                    @if ($lowongans->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $lowongans->previousPageUrl() }}">
                                                <i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Logika halaman --}}
                                    @php
                                        $current = $lowongans->currentPage();
                                        $last = $lowongans->lastPage();
                                        $visible = 3; // jumlah halaman di tengah
                                    @endphp

                                    {{-- Halaman pertama --}}
                                    <li class="page-item {{ $current === 1 ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $lowongans->url(1) }}">1</a>
                                    </li>

                                    {{-- Titik di awal --}}
                                    @if ($current > $visible)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    {{-- Halaman di tengah --}}
                                    @for ($i = max(2, $current - 1); $i <= min($last - 1, $current + 1); $i++)
                                        <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $lowongans->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endfor

                                    {{-- Titik di akhir --}}
                                    @if ($current < $last - ($visible - 1))
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif

                                    {{-- Halaman terakhir --}}
                                    @if ($last > 1)
                                        <li class="page-item {{ $current === $last ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $lowongans->url($last) }}">{{ $last }}</a>
                                        </li>
                                    @endif

                                    {{-- Tombol Next --}}
                                    @if ($lowongans->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $lowongans->nextPageUrl() }}">
                                                <i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i></span>
                                        </li>
                                    @endif
                                </ul>

                                {{-- MOBILE PAGINATION --}}
                                <ul class="pagination pagination-mobile pagination-style-01 fs-13 fw-500 mb-0 justify-content-center">
                                    {{-- Tombol Previous --}}
                                    @if ($lowongans->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="feather icon-feather-arrow-left fs-18"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $lowongans->previousPageUrl() }}">
                                                <i class="feather icon-feather-arrow-left fs-18"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Halaman aktif / total --}}
                                    <li class="page-item disabled">
                                        <span class="page-link border-0 bg-transparent fw-600">{{ $lowongans->currentPage() }} / {{ $lowongans->lastPage() }}</span>
                                    </li>

                                    {{-- Tombol Next --}}
                                    @if ($lowongans->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $lowongans->nextPageUrl() }}">
                                                <i class="feather icon-feather-arrow-right fs-18"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="feather icon-feather-arrow-right fs-18"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-3 shop-sidebar" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="mb-30px">
                        <span class="alt-font fw-500 fs-19 text-light d-block mb-10px">Filter by jenis</span>
                        <ul class="shop-filter category-filter fs-16">
                            @foreach($jenisPekerjaanList as $item)
                                <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>{{ $item->jenis_pekerjaan }}</a><span class="item-qty">{{ $item->total }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mb-30px">
                        <span class="alt-font fw-500 fs-19 text-light d-block mb-10px">Filter by Jenis Kelamin</span>
                        <ul class="shop-filter category-filter fs-16">
                            @foreach($jenisKelaminList  as $item)
                                @php
                                    // Tentukan ikon berdasarkan jenis kelamin
                                    switch ($item->jenis_kelamin) {
                                        case 'Laki-laki':
                                            $icon = 'bi-gender-male';
                                            break;
                                        case 'Perempuan':
                                            $icon = 'bi-gender-female';
                                            break;
                                        default:
                                            $icon = 'bi-gender-ambiguous';
                                            break;
                                    }
                                @endphp
                                <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>{{ $item->jenis_kelamin }} <i class="bi {{ $icon }} me-2"></i></a><span class="item-qty">{{ $item->total }}</span></li>
                            @endforeach
                        </ul>
                    </div>
                    {{-- <div class="mb-30px">
                        <span class="alt-font fw-500 fs-19 text-light d-block mb-10px">Filter by size</span>
                        <ul class="shop-filter price-filter fs-16">
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>S</a><span class="item-qty">08</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>M</a><span class="item-qty">05</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>L</a><span class="item-qty">25</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>XL</a><span class="item-qty">18</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>XXL</a><span class="item-qty">36</span></li>
                        </ul>
                    </div>
                    <div class="mb-30px">
                        <div class="d-flex align-items-center mb-20px">
                            <span class="alt-font fw-500 fs-19 text-light">New arrivals</span>
                            <div class="d-flex ms-auto">
                                <!-- start slider navigation -->
                                <div class="slider-one-slide-prev-1 icon-very-small swiper-button-prev slider-navigation-style-08 me-5px"><i class="fa-solid fa-arrow-left text-light"></i></div>
                                <div class="slider-one-slide-next-1 icon-very-small swiper-button-next slider-navigation-style-08 ms-5px"><i class="fa-solid fa-arrow-right text-light"></i></div>
                                <!-- end slider navigation -->
                            </div>
                        </div>
                        <div class="swiper slider-one-slide" data-slider-options='{ "slidesPerView": 1, "loop": true, "autoplay": { "delay": 5000, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "effect": "slide" }'>
                            <div class="swiper-wrapper">
                                <!-- start text slider item -->
                                <div class="swiper-slide">
                                    <div class="shop-filter new-arribals">
                                        <div class="d-flex align-items-center mb-20px">
                                            <figure class="mb-0">
                                                <a href="demo-fashion-store-single-product.html">
                                                    <img class="border-radius-4px w-80px" src="https://placehold.co/600x765" alt="">
                                                </a>
                                            </figure>
                                            <div class="col ps-25px">
                                                <a href="demo-fashion-store-single-product.html" class="text-light alt-font fw-500 d-inline-block lh-normal">Textured sweater</a>
                                                <div class="fs-15 lh-normal"><del class="me-5px">$30.00</del>$23.00</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-20px">
                                            <figure class="mb-0">
                                                <a href="demo-fashion-store-single-product.html">
                                                    <img class="border-radius-4px w-80px" src="https://placehold.co/600x765" alt="">
                                                </a>
                                            </figure>
                                            <div class="col ps-25px">
                                                <a href="demo-fashion-store-single-product.html" class="text-light alt-font fw-500 d-inline-block lh-normal">Traveller shirt</a>
                                                <div class="fs-15 lh-normal"><del class="me-5px">$50.00</del>$43.00</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <figure class="mb-0">
                                                <a href="demo-fashion-store-single-product.html">
                                                    <img class="border-radius-4px w-80px" src="https://placehold.co/600x765" alt="">
                                                </a>
                                            </figure>
                                            <div class="col ps-25px">
                                                <a href="demo-fashion-store-single-product.html" class="text-light alt-font fw-500 d-inline-block lh-normal">Crewneck tshirt</a>
                                                <div class="fs-15 lh-normal"><del class="me-5px">$20.00</del>$15.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end text slider item -->
                                <!-- start text slider item -->
                                <div class="swiper-slide">
                                    <div class="shop-filter new-arribals">
                                        <div class="d-flex align-items-center mb-20px">
                                            <figure class="mb-0">
                                                <a href="demo-fashion-store-single-product.html">
                                                    <img class="border-radius-4px w-80px" src="https://placehold.co/600x765" alt="">
                                                </a>
                                            </figure>
                                            <div class="col ps-25px">
                                                <a href="demo-fashion-store-single-product.html" class="text-light alt-font fw-500 d-inline-block lh-normal">Skinny trousers</a>
                                                <div class="fs-15 lh-normal"><del class="me-5px">$15.00</del>$10.00</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center mb-20px">
                                            <figure class="mb-0">
                                                <a href="demo-fashion-store-single-product.html">
                                                    <img class="border-radius-4px w-80px" src="https://placehold.co/600x765" alt="">
                                                </a>
                                            </figure>
                                            <div class="col ps-25px">
                                                <a href="demo-fashion-store-single-product.html" class="text-light alt-font fw-500 d-inline-block lh-normal">Sleeve sweater</a>
                                                <div class="fs-15 lh-normal"><del class="me-5px">$35.00</del>$30.00</div>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <figure class="mb-0">
                                                <a href="demo-fashion-store-single-product.html">
                                                    <img class="border-radius-4px w-80px" src="https://placehold.co/600x765" alt="">
                                                </a>
                                            </figure>
                                            <div class="col ps-25px">
                                                <a href="demo-fashion-store-single-product.html" class="text-light alt-font fw-500 d-inline-block lh-normal">Pocket white</a>
                                                <div class="fs-15 lh-normal"><del class="me-5px">$20.00</del>$15.00</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end text slider item -->
                            </div>
                            <!-- start slider navigation -->
                        </div>
                    </div>
                    <div>
                        <span class="alt-font fw-500 fs-19 text-light d-block mb-10px">Filter by tags</span>
                        <div class="shop-filter tag-cloud fs-16">
                            <a class="text-light" href="#">Coats</a>
                            <a class="text-light" href="#">Cotton</a>
                            <a class="text-light" href="#">Dresses</a>
                            <a class="text-light" href="#">Jackets</a>
                            <a class="text-light" href="#">Polyester</a>
                            <a class="text-light" href="#">Printed</a>
                            <a class="text-light" href="#">Shirts</a>
                            <a class="text-light" href="#">Shorts</a>
                            <a class="text-light" href="#">Tops</a>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </section>
@endsection
