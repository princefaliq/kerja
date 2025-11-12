@extends('crafto.master')
@section('title','Detil Lowongan Kerja')
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
            <div class="row align-items-center">
                <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ url('lowongan-kerja') }}">Lowongan</a></li>
                        <li>{{ $lowongan->judul }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- end section -->
    <section class="overlap-section text-center p-0 sm-pt-50px">
        <img class="rounded-circle box-shadow-extra-large w-150px h-150px border border-9 border-color-white" src="{{ $lowongan->user->avatar_url ? asset($lowongan->user->avatar_url) : 'https://placehold.co/125x125' }}" alt="{{ $lowongan->judul }}">
    </section>
    <section class="pt-60px pb-0 md-pt-30px">
        <div class="container">
            <div class="row">
                {{--<div class="col-4">
                    <div class="position-sticky top-50px">
                        <div class="card-custom justify-content-center border-0 fw-500 text-left alt-font bg-very-light-gray border-radius-6px overflow-hidden">
                            <h4 class="alt-font text-dark-gray fw-500 mb-10px text-center mt-3"> {{ $lowongan->user->name }} </h4>
                            <span class="fw-500 m-5 text-dark-gray d-block">{{ $lowongan->user->email }} s</span>
                        </div>
                    </div>
                </div>--}}
                @if (session('success'))
                    <div class="alert alert-success box-shadow-extra-large bg-white alert-dismissable">
                        <a href="#" class="close" data-bs-dismiss="alert" aria-label="close"><i class="fa-solid fa-xmark"></i></a>
                        <strong>Success!</strong> {{ session('success') }}.
                    </div>
                @endif
                <div class="col-12 product-info">
                    <span class="fw-500 text-dark-gray text-center d-block">{{ $lowongan->user->name }}</span>
                    <h4 class="alt-font text-dark-gray fw-500 mb-50px text-center">{{ $lowongan->judul }}</h4>
                    <div class="d-block d-sm-flex align-items-center mb-10px">
                        <a href="#" class="me-25px text-dark-gray fw-500 section-link xs-me-0"><i class="feather icon-feather-map-pin text-golden-yellow"></i> {{ $lowongan->lokasi }}</a>
                    </div>
                    <div class="d-block d-sm-flex align-items-center mb-10px">
                        <a href="#" class="me-25px text-dark-gray fw-500 section-link xs-me-0"><i class="feather icon-feather-calendar text-golden-yellow"></i> Diposting {{ $lowongan->created_at ? $lowongan->created_at->diffForHumans() : '-' }}</a>
                    </div>
                    <div class="d-block d-sm-flex align-items-center mb-30px">
                        <a href="#" class="me-25px text-dark-gray fw-500 section-link xs-me-0"><i class="feather icon-feather-bell text-golden-yellow"></i> Batas waktu lamaran kurang {{ $lowongan->batas_lamaran ? $lowongan->batas_lamaran->endOfDay()->diffForHumans() : '-' }} - {{  \Carbon\Carbon::parse($lowongan->batas_lamaran)->translatedFormat('d F Y') }}</a>
                    </div>
                    <div class="mb-2 h-1px w-100 bg-extra-medium-gray sm-mt-10px xs-mb-8"></div>
                    <div class="row mb-10px">
                        <div class="col-4">
                            <span>
                                Bidang pekerjaan
                            </span>
                            <p class="text-dark">
                                {{ $lowongan->bidang_pekerjaan }}
                            </p>
                        </div>
                        <div class="col-4">
                            <span>
                                Jenis pekerjaan
                            </span>
                            <p class="text-dark">
                                {{ $lowongan->jenis_pekerjaan }}
                            </p>
                        </div>
                        <div class="col-4">
                            <span>
                                Tipe pekerjaan
                            </span>
                            <p class="text-dark">
                                {{ $lowongan->tipe_pekerjaan }}
                            </p>
                        </div>
                        <div class="col-4">
                            <span>
                                Jenis kelamin
                            </span>
                            <p class="text-dark">
                                {{ $lowongan->jenis_kelamin }}
                            </p>
                        </div>
                        <div class="col-4">
                            <span>
                                Rentang gaji
                            </span>
                            <p class="text-dark">
                                {{ !empty($lowongan->rentang_gaji) ? $lowongan->rentang_gaji : 'Dirahasiakan' }}
                            </p>
                        </div>
                        <div class="col-4">
                            <span>
                                Jumlah Lowongan
                            </span>
                            <p class="text-dark">
                                @if($lowongan->jumlah_lowongan) {{ $lowongan->jumlah_lowongan }} @else 0 @endif Orang
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- start section -->
    <section id="tab" class="pt-1 sm-pt-10px">
        <div class="container">
            <div class="row">
                <div class="col-12 tab-style-04">
                    <ul class="nav nav-tabs border-0 justify-content-center alt-font fs-19">
                        <li class="nav-item"><a data-bs-toggle="tab" href="#tab_five1" class="nav-link active">Deskripsi Pekerjaan<span class="tab-border bg-dark-gray"></span></a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_five2">Persyaratan Khusus<span class="tab-border bg-dark-gray"></span></a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_five3">Persyaratan Umum<span class="tab-border bg-dark-gray"></span></a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab_five4" data-tab="review-tab">Keterampilan<span class="tab-border bg-dark-gray"></span></a></li>
                    </ul>
                    <div class="mb-5 h-1px w-100 bg-extra-medium-gray sm-mt-10px xs-mb-8"></div>
                    <div class="tab-content">
                        <!-- start tab content -->
                        <div class="tab-pane fade in active show" id="tab_five1">
                            <div class="row align-items-center justify-content-center">
                                <div class="col-lg-12 md-mb-40px">
                                    {!! $lowongan->deskripsi_pekerjaan !!}
                                </div>

                            </div>
                        </div>
                        <!-- end tab content -->
                        <!-- start tab content -->
                        <div class="tab-pane fade in" id="tab_five2">
                            <div class="row">
                                <div class="col-12 col-md-12 last-paragraph-no-margin sm-mb-30px">
                                    {!! $lowongan->persyaratan_khusus !!}
                                </div>
                            </div>
                        </div>
                        <!-- end tab content -->
                        <!-- start tab content -->
                        <div class="tab-pane fade in" id="tab_five3">
                            <div class="row">
                                <div class="col-4">
                                    <span>
                                        Minimal pendidikan
                                    </span>
                                    <p class="text-dark">
                                        {{ $lowongan->pendidikan_minimal }}
                                    </p>
                                </div>
                                <div class="col-4">
                                    <span>
                                        Status pernikahan
                                    </span>
                                    <p class="text-dark">
                                        {{ $lowongan->status_pernikahan }}
                                    </p>
                                </div>
                                <div class="col-4">
                                    <span>
                                        Minimal pengalaman
                                    </span>
                                    <p class="text-dark">
                                        {{ !empty($lowongan->pengalaman_minimal) ? $lowongan->pengalaman_minimal : '0' }} tahun
                                    </p>
                                </div>
                                <div class="col-4">
                                    <span>
                                        Kondisi fisik
                                    </span>
                                    <p class="text-dark">
                                        {{ $lowongan->kondisi_fisik }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- end tab content -->
                        <!-- start tab content -->
                        <div class="tab-pane fade in" id="tab_five4">
                            <div class="row align-items-center mb-6 sm-mb-10">
                                {!! $lowongan->keterampilan !!}
                            </div>
                        </div>
                        <!-- end tab content -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="text-center">
            @auth
                @role('User')
                    @if ($sudahMelamar)
                        <button class="alt-font btn btn-small btn-box-shadow btn-secondary btn-round-edge" disabled>
                            <i class="feather icon-feather-check"></i>
                            <span class="button-text">Sudah Melamar</span>
                        </button>
                    @elseif (!$sudahIsi)
                        <a href="{{ url('profile') }}" class="alt-font btn btn-small btn-box-shadow btn-base-color btn-round-edge left-icon">
                            <i class="feather icon-feather-edit"></i>
                            <span class="button-text">Isi Biodata untuk Melamar</span>
                        </a>
                    @elseif (!$sudahAbsen)
                        <a href="{{ url('profile') }}" class="alt-font btn btn-small btn-box-shadow btn-base-color btn-round-edge left-icon">
                            <i class="feather icon-feather-camera"></i>
                            <span class="button-text">Absen Dulu!</span>
                        </a>
                    @else
                        <form id="lamarForm" action="{{ route('melamar.daftar') }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="id_lowongan" value="{{ $lowongan->id }}">
                            <button type="button" id="btnLamar" class="alt-font btn btn-small btn-box-shadow btn-base-color btn-round-edge left-icon add-to-cart">
                                <i class="feather icon-feather-file"></i>
                                <span class="button-text">Lamar</span>
                            </button>
                        </form>
                    @endif
                @endrole

            @else
                <a href="{{ route('login') }}" class="alt-font btn btn-small btn-box-shadow btn-base-color btn-round-edge left-icon">
                    <i class="feather icon-feather-log-in"></i>
                    <span class="button-text">Login untuk Melamar</span>
                </a>
            @endauth
        </div>
    </section>
@endsection

@push('js')

    <script>
        document.getElementById('btnLamar').addEventListener('click', function (e) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengirim lamaran untuk lowongan ini.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, Lamar Sekarang',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('lamarForm').submit();
                }
            });
        });
    </script>
@endpush
