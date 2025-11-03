@extends('crafto.master')
@section('title','Lowongan Kerja')

@push('css')
    <style>
        /* --- GENERAL STYLE --- */
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

        .job-company img {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
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

        /* --- PAGINATION --- */
        /* --- PAGINATION STYLING --- */
        .pagination-style-01 .page-item {
            margin: 0 4px;
        }

        .pagination-style-01 .page-link {
            border: none;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            text-align: center;
            line-height: 36px;
            color: #ffffff; /* Default: teks putih */
            background-color: rgba(255, 255, 255, 0.1); /* Transparan lembut */
            transition: all 0.3s ease;
        }

        /* 🟡 Hover efek: kuning & teks hitam */
        .pagination-style-01 .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: #fdd835 !important;
            color: #000000 !important;
        }

        /* ✅ Aktif: tetap kuning & hitam */
        .pagination-style-01 .page-item.active .page-link {
            background-color: #fdd835;
            color: #000000;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(253, 216, 53, 0.4);
        }

        /* ❌ Disabled: tanpa lingkaran & teks pudar */
        .pagination-style-01 .page-item.disabled .page-link {
            background: none;
            color: rgba(255, 255, 255, 0.5);
            border: none;
            border-radius: 0;
            pointer-events: none;
            box-shadow: none;
        }

        /* --- SIDEBAR FILTER --- */
        .filter-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .filter-box h5 {
            font-size: 17px;
            color: #fff;
            margin-bottom: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 6px;
        }

        .filter-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .filter-box ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 6px 10px;
            font-size: 14px;
            color: #ddd;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            transition: background 0.2s ease;
        }

        .filter-box ul li:hover {
            background: rgba(255, 255, 255, 0.08);
            border-radius: 6px;
        }

        .filter-box ul li a {
            display: flex;
            align-items: center;
            gap: 6px;
            color: #f0f0f0;
            text-decoration: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 140px; /* cegah teks terlalu panjang */
        }

        .filter-box ul li a:hover {
            color: #fdd835;
        }

        .filter-box ul li span {
            min-width: 30px;
            text-align: right;
            color: #aaa;
        }

        .filter-box ul li a i {
            font-size: 1rem;
            color: #fdd835;
        }

        /* --- RESPONSIVE --- */
        @media (max-width: 768px) {
            .job-card {
                margin-bottom: 15px;
            }

            .filter-box ul li a {
                max-width: 100%;
            }
        }

    </style>

@endpush

@section('content')
    <section class="bg-dark-midnight-blue text-light pt-10 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ url('lowongan-kerja') }}">Lowongan</a></li>

                    </ul>
                </div>
            </div>
        </div>
    </section>
    <section class="pt-5 pb-10 ps-4 pe-4">
        <div class="container-fluid">
            <div class="row">
                <!-- Kolom utama -->
                <div class="col-lg-9">
                    @if ($lowongans->isEmpty())
                        <p class="text-light text-center mt-5">Tidak ada lowongan yang tersedia saat ini.</p>
                    @else
                        <div class="row g-4">
                            @foreach ($lowongans as $lowongan)
                                <div class="col-xl-4 col-md-6">
                                    <div class="job-card p-3 h-100 d-flex flex-column justify-content-between">
                                        <div>
                                            <div class="text-center job-company mb-3">
                                                <img src="{{ $lowongan->user->avatar_url ? asset($lowongan->user->avatar_url) : 'https://placehold.co/80x80' }}" alt="Logo Perusahaan">
                                            </div>
                                            <h5 class="job-title text-center">{{ Str::limit($lowongan->judul, 35, '...') }}</h5>
                                            <p class="job-location text-center mb-2">
                                                <i class="bi bi-geo-alt"></i> {{ Str::limit($lowongan->lokasi, 25, '...') }}
                                            </p>
                                            <p class="job-meta mb-1"><strong>Pendidikan:</strong> {{ $lowongan->pendidikan_minimal }}</p>
                                            <p class="job-meta mb-1"><strong>Jenis Kelamin:</strong> {{ $lowongan->jenis_kelamin }}</p>
                                            <p class="job-meta mb-1"><strong>Batas Lamaran:</strong> {{ $lowongan->batas_lamaran ? $lowongan->batas_lamaran->diffForHumans() : '-' }}</p>
                                        </div>

                                        <div class="job-footer mt-2">
                                            <span class="text-capitalize">{{ $lowongan->bidang_pekerjaan }}</span>
                                            <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="job-apply">
                                                Lamar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $lowongans->links('crafto.pagination.paging') }}
                        <div class="pagination-info">
                            Showing {{ $lowongans->firstItem() }} to {{ $lowongans->lastItem() }} of {{ $lowongans->total() }} results
                        </div>
                    </div>

                </div>

                <!-- Sidebar -->
                <div class="col-lg-3 mt-4 mt-lg-0">
                    {{-- Filter Jenis Pekerjaan --}}
                    <div class="filter-box mb-4">
                        <h5 class="alt-font fw-600 fs-18 mb-3">Filter Jenis Pekerjaan</h5>
                        <ul class="filter-list list-unstyled mb-0">
                            @foreach($jenisPekerjaanList as $item)
                                <li class="d-flex justify-content-between align-items-center py-1 px-2 border-bottom border-opacity-10">
                                    <a href="#" class="text-decoration-none text-light flex-grow-1 text-truncate">
                                        {{ $item->jenis_pekerjaan }}
                                    </a>
                                    <span class="text-secondary fw-500">{{ $item->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Filter Jenis Kelamin --}}
                    <div class="filter-box">
                        <h5 class="alt-font fw-600 fs-18 mb-3">Filter Jenis Kelamin</h5>
                        <ul class="filter-list list-unstyled mb-0">
                            @foreach($jenisKelaminList as $item)
                                @php
                                    switch ($item->jenis_kelamin) {
                                        case 'Laki-laki': $icon = 'bi-gender-male'; break;
                                        case 'Perempuan': $icon = 'bi-gender-female'; break;
                                        default: $icon = 'bi-gender-ambiguous'; break;
                                    }
                                @endphp
                                <li class="d-flex justify-content-between align-items-center py-1 px-2 border-bottom border-opacity-10">
                                    <a href="#" class="text-decoration-none text-light d-flex align-items-center gap-2 flex-grow-1 text-nowrap">
                                        <i class="bi {{ $icon }}"></i>
                                        {{ $item->jenis_kelamin }}
                                    </a>
                                    <span class="text-secondary fw-500">{{ $item->total }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
