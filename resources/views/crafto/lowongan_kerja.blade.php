@extends('crafto.master')
@section('title','Lowongan Kerja')

@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        /* === GENERAL === */
        body {
            background-color: #0b1a2a;
        }

        /* === JOB CARD === */
        .job-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            transition: all 0.3s ease;
            overflow: hidden;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
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

        .job-company-name {
            font-size: 15px;
            font-weight: 500;
            margin-top: 8px;
            color: #fdd835;
            text-align: center;
            transition: color 0.3s;
        }

        .job-company-name:hover {
            color: #fff;
            text-decoration: underline;
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
            align-items: center !important; /* kunci posisi tengah vertikal */
            flex-wrap: nowrap;
            gap: 6px;
            min-height: 48px; /* jaga agar tinggi area footer konsisten */
        }
        .job-footer span {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .job-apply {
            background: #fdd835;
            color: #000;
            font-weight: 600;
            border: none;
            border-radius: 6px;
            padding: 6px 12px;
            transition: 0.3s;
            text-decoration: none;
        }

        .job-apply:hover {
            background: #ffe95c;
            color: #000;
        }

        /* === PAGINATION === */
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
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .pagination-style-01 .page-item:not(.active):not(.disabled) .page-link:hover {
            background-color: #fdd835 !important;
            color: #000000 !important;
        }

        .pagination-style-01 .page-item.active .page-link {
            background-color: #fdd835;
            color: #000000;
            font-weight: 600;
            box-shadow: 0 0 10px rgba(253, 216, 53, 0.4);
        }

        .pagination-style-01 .page-item.disabled .page-link {
            background: none;
            color: rgba(255, 255, 255, 0.5);
            border: none;
            pointer-events: none;
        }

        /* === SIDEBAR FILTER === */
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
            max-width: 140px;
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

        /* === SELECT2 THEME DARK === */
        .select2-container--default .select2-selection--single {
            background-color: #1b2838;
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 8px;
            height: 42px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff;
            line-height: 40px;
            padding-left: 12px;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #ccc;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow b {
            border-color: #ccc transparent transparent transparent;
        }

        .select2-dropdown {
            background-color: #1b2838;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            border-radius: 8px;
        }

        .select2-results__option {
            padding: 8px 12px;
            color: #fff;
        }

        .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: #fff !important;
        }

        /* Responsif agar teks bidang panjang tidak mendorong tombol turun */
        @media (max-width: 768px) {
            .job-footer {
                flex-wrap: wrap;
                justify-content: center;
                gap: 8px;
            }
            .job-footer span {
                text-align: center;
                flex-basis: 100%;
            }
        }
        /* === STICKY SIDEBAR FILTER === */
        @media (min-width: 992px) { /* aktif hanya di layar besar */
            .col-lg-3 {
                position: relative;
            }

            .filter-sticky {
                position: sticky;
                top: 100px; /* jarak dari navbar, sesuaikan */
                z-index: 98;
                max-height: calc(100vh - 120px);
                overflow-y: auto;
                scrollbar-width: thin;
                scrollbar-color: rgba(255,255,255,0.3) transparent;
            }

            /* scrollbar untuk chrome/safari */
            .filter-sticky::-webkit-scrollbar {
                width: 6px;
            }

            .filter-sticky::-webkit-scrollbar-thumb {
                background-color: rgba(255, 255, 255, 0.2);
                border-radius: 4px;
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
                                                <img src="{{ $lowongan->user->avatar_url ? asset($lowongan->user->avatar_url) : 'https://placehold.co/80x80' }}" alt="Logo Perusahaan {{ $lowongan->user->name }}">

                                                {{-- 🔗 Nama Perusahaan dengan link ke profil --}}
                                                <a href="{{ optional($lowongan->perusahaan)->slug ? route('perusahaan.show', optional($lowongan->perusahaan)->slug) : '#' }}"
                                                   class="job-company-name d-block">
                                                    {{ $lowongan->user->name }}
                                                </a>

                                            </div>

                                            <h5 class="job-title text-center">{{ Str::limit($lowongan->judul, 35, '...') }}</h5>
                                            <p class="job-location text-center mb-2">
                                                <i class="bi bi-geo-alt"></i> {{ Str::limit($lowongan->lokasi, 25, '...') }}
                                            </p>
                                            <p class="job-meta mb-1"><strong>Pendidikan:</strong> {{ $lowongan->pendidikan_minimal }}</p>
                                            <p class="job-meta mb-1"><strong>Jenis Kelamin:</strong> {{ $lowongan->jenis_kelamin }}</p>
                                            <p class="job-meta mb-1"><strong>Jumlah Lowongan:</strong> {{ $lowongan->jumlah_lowongan }} Orang</p>
                                            <p class="job-meta mb-1">
                                                @php
                                                    $batas = $lowongan->batas_lamaran ? $lowongan->batas_lamaran->endOfDay() : null;
                                                @endphp

                                                @if ($batas && $batas->isFuture())
                                                    <strong>Batas Lamaran:</strong>
                                                    {{ now()->diffForHumans($batas, [
                                                        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                                        'parts' => 2
                                                    ]) }}
                                                @elseif($batas)
                                                    <strong>Melewati batas:</strong>
                                                    {{ $batas->diffForHumans(now(), [
                                                        'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                                        'parts' => 2
                                                    ]) }}
                                                @else
                                                    <strong>Batas lamaran belum ditentukan</strong>
                                                @endif
                                            </p>
                                        </div>

                                        <div class="job-footer mt-2">
                                            <span class="text-capitalize">{{ $lowongan->bidang_pekerjaan }}</span>
                                            <a href="{{ url($lowongan->slug) }}" class="job-apply">
                                                Lamar
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="mt-4">
                        {{ $lowongans->links('crafto.pagination.paging') }}
                        <div class="pagination-info">
                            Showing {{ $lowongans->firstItem() }} to {{ $lowongans->lastItem() }} of {{ $lowongans->total() }} results
                        </div>
                    </div>
                </div>

                {{-- SIDEBAR FILTER --}}
                <div class="col-lg-3 mt-4 mt-lg-0">
                    <div class="filter-sticky">
                        <div class="filter-box mb-4">
                            <h5 class="alt-font fw-600 fs-18 mb-3">Filter Jenis Pekerjaan</h5>
                            <ul class="filter-list list-unstyled mb-0">
                                <li class="py-1 px-2 border-bottom border-opacity-10 d-flex justify-content-between">
                                    <a href="{{ url('lowongan-kerja') }}" class="text-decoration-none text-light">Semua</a>
                                    <span class="text-secondary fw-500">{{ $jenisPekerjaanList->sum('total') }}</span>
                                </li>
                                @foreach($jenisPekerjaanList as $item)
                                    <li class="d-flex justify-content-between align-items-center py-1 px-2 border-bottom border-opacity-10">
                                        <a href="{{ request()->fullUrlWithQuery(['jenis_pekerjaan' => $item->jenis_pekerjaan]) }}"
                                           class="text-decoration-none flex-grow-1 text-truncate {{ request('jenis_pekerjaan') == $item->jenis_pekerjaan ? 'text-warning fw-bold' : 'text-light' }}">
                                            {{ $item->jenis_pekerjaan }}
                                        </a>
                                        <span class="text-secondary fw-500">{{ $item->total }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-box mb-4">
                            <h5 class="alt-font fw-600 fs-18 mb-3">Filter Jenis Kelamin</h5>
                            <ul class="filter-list list-unstyled mb-0">
                                <li class="py-1 px-2 border-bottom border-opacity-10 d-flex justify-content-between">
                                    <a href="{{ url('lowongan-kerja') }}" class="text-decoration-none text-light">Semua</a>
                                    <span class="text-secondary fw-500">{{ $jenisKelaminList->sum('total') }}</span>
                                </li>
                                @foreach($jenisKelaminList as $item)
                                    @php
                                        if ($item->jenis_kelamin === 'Laki-laki') {
                                            $icon = 'bi-gender-male';
                                        } elseif ($item->jenis_kelamin === 'Perempuan') {
                                            $icon = 'bi-gender-female';
                                        } else {
                                            $icon = 'bi-gender-ambiguous';
                                        }
                                    @endphp
                                    <li class="d-flex justify-content-between align-items-center py-1 px-2 border-bottom border-opacity-10">
                                        <a href="{{ request()->fullUrlWithQuery(['jenis_kelamin' => $item->jenis_kelamin]) }}"
                                           class="text-decoration-none d-flex align-items-center gap-2 flex-grow-1 text-nowrap {{ request('jenis_kelamin') == $item->jenis_kelamin ? 'text-warning fw-bold' : 'text-light' }}">
                                            <i class="bi {{ $icon }}"></i>
                                            {{ $item->jenis_kelamin }}
                                        </a>
                                        <span class="text-secondary fw-500">{{ $item->total }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="filter-box mb-4">
                            <h5 class="alt-font fw-600 fs-18">Filter Perusahaan</h5>
                            <form action="{{ url('lowongan-kerja') }}" method="GET">
                                <select class="form-select select2" name="perusahaan" onchange="this.form.submit()">
                                    <option value="">Semua perusahaan</option>
                                    @foreach($perusahaanList as $item)
                                        <option value="{{ $item['nama'] }}" {{ request('perusahaan') == $item['nama'] ? 'selected' : '' }}>
                                            {{ $item['nama'] }} ({{ $item['total'] }})
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <!-- Select2 JS & CSS -->

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $(document).ready(function() {
                $('.select2').select2({
                    width: '100%',
                    theme: 'default',
                    dropdownAutoWidth: true
                });
            });
        });
    </script>
@endpush
