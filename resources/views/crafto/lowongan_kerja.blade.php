@extends('crafto.master')
@section('title','Lowongan Kerja')
@push('css')
    <style>
        .card-custom {
            min-height: 400px;  /* minimal tinggi */
            max-height: 400px;  /* batas maksimal */
            overflow-y: auto;   /* kalau isi terlalu panjang, muncul scrollbar */
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
                                                        <div class="col-12 text-end">
                                                            <img src="{{ $lowongan->user->avatar ? asset($lowongan->user->avatar) : 'https://placehold.co/58x58' }}" alt="Avatar" class="img-fluid" style="width:58px;">
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
                                        <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="alt-font text-light fs-19 fw-500">{{ $lowongan->bidang_pekerjaan }}</a>
                                        <div class="price lh-22 fs-16">{{ $lowongan->jenis_pekerjaan }}</div>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                    @endif
                    <div class="w-100 d-flex mt-4 justify-content-center md-mt-30px">
                        {{ $lowongans->links() }}
                        {{--<ul class="pagination pagination-style-01 fs-13 fw-500 mb-0">
                            <li class="page-item"><a class="page-link" href="#"><i class="feather icon-feather-arrow-left fs-18 d-xs-none"></i></a></li>
                            <li class="page-item"><a class="page-link" href="#">01</a></li>
                            <li class="page-item active"><a class="page-link" href="#">02</a></li>
                            <li class="page-item"><a class="page-link" href="#">03</a></li>
                            <li class="page-item"><a class="page-link" href="#">04</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="feather icon-feather-arrow-right fs-18 d-xs-none"></i></a></li>
                        </ul>--}}
                    </div>
                </div>
                <div class="col-xxl-2 col-lg-3 shop-sidebar" data-anime='{ "el": "childs", "translateY": [-15, 0], "opacity": [0,1], "duration": 300, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <div class="mb-30px">
                        <span class="alt-font fw-500 fs-19 text-light d-block mb-10px">Filter by categories</span>
                        <ul class="shop-filter category-filter fs-16">
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Jeans</a><span class="item-qty">22</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Trousers</a><span class="item-qty">28</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Swimwear</a><span class="item-qty">36</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Casual shirts</a><span class="item-qty">24</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Winter jackets</a><span class="item-qty">26</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Leggings</a><span class="item-qty">33</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-category-cb"></span>Dupattas</a><span class="item-qty">22</span></li>
                        </ul>
                    </div>
                    <div class="mb-30px">
                        <span class="alt-font fw-500 fs-19 text-light d-block mb-10px">Filter by color</span>
                        <ul class="shop-filter color-filter fs-16">
                            <li><a class="text-light" href="#"><span class="product-cb product-color-cb" style="background-color:#232323"></span>Black</a><span class="item-qty">05</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-color-cb" style="background-color:#5881bf"></span>Blue</a><span class="item-qty">24</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-color-cb" style="background-color:#9f684f"></span>Brown</a><span class="item-qty">32</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-color-cb" style="background-color:#87a968"></span>Green</a><span class="item-qty">22</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-color-cb" style="background-color:#b14141"></span>Maroon</a><span class="item-qty">09</span></li>
                            <li><a class="text-light" href="#"><span class="product-cb product-color-cb" style="background-color:#d9653e"></span>Orange</a><span class="item-qty">06</span></li>
                        </ul>
                    </div>
                    <div class="mb-30px">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
