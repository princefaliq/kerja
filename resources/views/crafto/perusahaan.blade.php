@extends('crafto.master')
@section('title','Profile Perusahaan')

@push('css')

    <style>
        body {
            background-color: #0b1a2a;
        }

        /* --- JOB CARD --- */
        .job-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            color: #fff;
        }

        .job-card:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
        }

        .job-title {
            font-size: 18px;
            font-weight: 600;
            margin: 8px 0 4px;
        }

        .job-location,
        .job-meta {
            font-size: 14px;
            opacity: 0.8;
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 8px;
            margin-top: 10px;
        }

        .job-apply {
            background: #fdd835;
            color: #000;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            transition: 0.3s;
        }

        .job-apply:hover {
            background: #ffe95c;
            color: #000;
        }

        /* --- Swiper --- */
        .swiper {
            padding-bottom: 50px;
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: #fdd835;
            transition: color 0.3s;
        }

        .swiper-button-prev:hover,
        .swiper-button-next:hover {
            color: #fff;
        }

        .swiper-pagination-bullet {
            background: #fdd835;
            opacity: 0.6;
        }

        .swiper-pagination-bullet-active {
            opacity: 1;
            background: #ffe95c;
        }

        @media (max-width: 768px) {
            .job-card { margin-bottom: 15px; }
        }
    </style>
@endpush

@section('content')
    <section class="bg-dark-midnight-blue text-light pt-8 ps-6 pe-6">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="#">Profile</a></li>
                        <li>Perusahaan</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            {{-- === PROFIL PERUSAHAAN === --}}
            <div class="row mb-8 align-items-center">
                <div class="col-lg-6 md-mb-50px">
                    <figure class="position-relative mb-0 overflow-hidden">
                        <img src="{{ url($user->avatar_url) }}" class="w-100 rounded" alt="">
                    </figure>
                </div>

                <div class="col-xl-5 col-lg-6 offset-xl-1 text-center text-md-start">
                    <h2 class="text-warning fw-600 ls-minus-3px alt-font">{{ $user->name }}</h2>
                    <div class="bg-yellow fw-600 lh-30 text-dark border-radius-30px ps-20px pe-20px fs-11 mb-25px d-inline-block">
                        {{ $perusahaan->bidang ?? '-' }}
                    </div>
                    <p class="text-light" >{{ $perusahaan->deskripsi ?? '-' }}</p>
                    <p class="text-light">
                        <i class="fa fa-location-dot me-2"></i> {{ $perusahaan->alamat ?? '-' }} <br>
                        <i class="fa-regular fa-envelope me-2"></i> {{ $user->email ?? '-' }}
                    </p>
                    <div class="mt-3">
                        <a href="{{ $perusahaan->website ?? '#' }}" class="btn btn-medium btn-yellow btn-box-shadow d-inline-block align-middle me-20px sm-me-0 sm-mb-30px">Website <i class="fa fa-globe"></i></a>
                        <a href="tel:{{ $user->no_hp ?? '#' }}" class="btn btn-medium text-light fs-18 fw-600 btn-box-shadow d-inline-block align-middle me-20px sm-me-0 sm-mb-30px">
                            {{ $user->no_hp ?? '-' }} <i class="fa fa-phone"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- === LOWONGAN SLIDER === --}}
            <h4 class="text-center text-warning mb-4">Lowongan dari Perusahaan Ini</h4>

            <div class="swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach($lowongans as $lowongan)
                        <div class="swiper-slide">
                            <div class="job-card p-3 h-100 d-flex flex-column justify-content-between">
                                <div>
                                    <h5 class="job-title text-center">{{ Str::limit($lowongan->judul, 35, '...') }}</h5>
                                    <p class="job-location text-center mb-2">
                                        <i class="bi bi-geo-alt"></i> {{ Str::limit($lowongan->lokasi, 25, '...') }}
                                    </p>
                                    <p class="job-meta mb-1"><strong>Pendidikan:</strong> {{ $lowongan->pendidikan_minimal }}</p>
                                    <p class="job-meta mb-1"><strong>Jenis Kelamin:</strong> {{ $lowongan->jenis_kelamin }}</p>
                                    <p class="job-meta mb-1"><strong>Jumlah Lowongan:</strong> {{ $lowongan->jumlah_lowongan }} Orang</p>
                                    <p class="job-meta mb-1"><strong>Batas Lamaran:</strong> {{ $lowongan->batas_lamaran ? $lowongan->batas_lamaran->diffForHumans() : '-' }}</p>
                                </div>

                                <div class="job-footer mt-2">
                                    <span class="text-capitalize">{{ $lowongan->bidang_pekerjaan }}</span>
                                    <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="job-apply">Lamar</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


            </div>
        </div>
    </section>
@endsection

@push('js')

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            new Swiper(".mySwiper", {
                slidesPerView: 3,
                spaceBetween: 30,
                loop: true,
                autoplay: { delay: 4000 },
                pagination: {
                    el: ".swiper-pagination",
                    clickable: true,
                },
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    320: { slidesPerView: 1 },
                    768: { slidesPerView: 2 },
                    1200: { slidesPerView: 3 },
                }
            });
        });
    </script>
@endpush
