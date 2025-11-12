@extends('master')
@section('title','Detil Pelamar')
@section('lamaran','show')

@push('css')


    <style>
        /* Styling ringan, tetap sesuai gaya Metronic */
        .profile-avatar {
            border-radius: 1rem;
            border: 3px solid #eff2f5;
            transition: all .3s;
        }
        .profile-avatar:hover {
            transform: scale(1.02);
            border-color: #17C653;
        }
        .profile-section {
            background-color: #f9f9f9;
            border-radius: .75rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        .info-label {
            color: #5e6278;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .info-value {
            font-weight: 600;
            color: #181c32;
            font-size: 15px;
        }
        .doc-frame {
            border: 1px solid #e5eaee;
            border-radius: .75rem;
            width: 100%;
            height: 500px;
        }
        .doc-missing {
            font-size: 15px;
            color: #f1416c;
            font-weight: 500;
        }
    </style>
@endpush

@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Detil Pelamar</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600"><a href="/" class="text-hover-primary">Home</a></li>
                    <li class="breadcrumb-item text-gray-600">Lamaran Management</li>
                    <li class="breadcrumb-item text-gray-600">Lamaran</li>
                    <li class="breadcrumb-item text-gray-500">Detil Pelamar</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card card-flush border-0 shadow-sm rounded-4">
                <div class="card-header align-items-center py-5">
                    <div class="card-title">
                        <h2><i class="bi bi-person-vcard-fill fs-2 text-primary me-2"></i>BIODATA PELAMAR</h2>
                    </div>
                </div>

                <div class="card-body">
                    <div class="text-center mb-10">
                        <img src="{{ $profile->user->avatarUrl ? url($profile->user->avatarUrl) : 'https://placehold.co/300x300' }}"
                             alt="Foto Profil" height="200" class="profile-avatar shadow-sm mb-4">
                        <h3 class="fw-bold text-dark mb-1 text-uppercase">{{ $profile->user->name }}</h3>
                    </div>

                    <div class="separator my-10"></div>

                    <!-- Informasi Dasar -->
                    <div class="row text-center mb-10">
                        <div class="col-md-3 col-6 mb-5">
                            <div class="info-label">NIK</div>
                            <div class="info-value">{{ $profile->nik }}</div>
                        </div>
                        <div class="col-md-3 col-6 mb-5">
                            <div class="info-label">Tanggal Lahir</div>
                            <div class="info-value">
                                {{ \Carbon\Carbon::parse($profile->tgl_lahir)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                ({{ \Carbon\Carbon::parse($profile->tgl_lahir)->age }} tahun)
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-5">
                            <div class="info-label">Jenis Kelamin</div>
                            <div class="info-value">{{ ucfirst($profile->jenis_kelamin) }}</div>
                        </div>
                        <div class="col-md-3 col-6 mb-5">
                            <div class="info-label">Status Pernikahan</div>
                            <div class="info-value">{{ $profile->status_pernikahan }}</div>
                        </div>
                    </div>

                    <!-- Informasi Kontak -->
                    <div class="row text-center mb-10">
                        <div class="col-md-6 mb-5">
                            <div class="info-label">Nomor Handphone</div>
                            <div class="info-value">{{ $profile->user->no_hp ?? '-' }}</div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $profile->user->email ?? '-' }}</div>
                        </div>
                    </div>


                    <!-- Alamat -->
                    <div class="profile-section">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-geo-alt-fill me-2"></i>Alamat Lengkap</h5>
                        <p class="mb-0 text-gray-700 fs-6">
                            {{ $profile->provinsi }}, {{ $profile->kabupaten }}, {{ $profile->kecamatan }},
                            {{ $profile->desa }}, {{ $profile->alamat }}
                        </p>
                    </div>

                    <!-- Pendidikan -->
                    <div class="profile-section">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-mortarboard-fill me-2"></i>Pendidikan Terakhir</h5>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="info-label">Tingkat</div>
                                <div class="info-value">{{ $profile->pendidikan_terahir ?? '-' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Jurusan</div>
                                <div class="info-value">{{ $profile->jurusan ?? '-' }}</div>
                            </div>
                            <div class="col-md-4">
                                <div class="info-label">Sekolah / Universitas</div>
                                <div class="info-value">{{ $profile->nama_sekolah ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- Disabilitas -->
                    <div class="profile-section">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-person-wheelchair me-2"></i>Disabilitas</h5>
                        <p class="fs-6 mb-0">
                            @if($profile->disabilitas)
                                <span class="badge bg-success-subtle text-success fs-6 px-4 py-2">
                                    {{ ucfirst($profile->disabilitas) }}
                                </span>
                            @else
                                <span class="badge bg-secondary-subtle text-muted fs-6 px-4 py-2">
                                    Tidak ada disabilitas
                                </span>
                            @endif
                        </p>
                    </div>

                    <!-- Dokumen -->
                    <div class="profile-section">
                        <h5 class="fw-bold mb-4 text-primary"><i class="bi bi-archive-fill me-2"></i>Dokumen Pelamar</h5>
                        @foreach ([
                            'Kartu Tanda Penduduk' => 'ktpUrl',
                            'Curriculum Vitae' => 'cvUrl',
                            'Ijazah dan Transkrip' => 'ijazahUrl',
                            'Kartu Tanda Pencari Kerja' => 'ak1Url',
                            'Sertifikat' => 'sertifikatUrl',
                            'Syarat Lain' => 'syarat_lainUrl',
                        ] as $label => $field)
                            <div class="mb-10">
                                <h6 class="fw-semibold text-dark mb-3">
                                    <i class="bi bi-file-earmark-fill text-primary me-2"></i>{{ $label }}
                                </h6>
                                @if(!empty($profile->$field))
                                    <iframe src="{{ url($profile->$field) }}" class="doc-frame"></iframe>
                                @else
                                    <div class="doc-missing"><i class="bi bi-sign-stop-fill me-2"></i>{{ $label }} tidak tersedia</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                <!--begin::Sticky Footer (Tombol Tutup Tab)-->
                <div class="card-footer bg-body position-sticky bottom-0 z-index-3 border-top d-flex justify-content-center py-5 shadow-sm">
                    <button type="button" class="btn btn-light-danger" onclick="window.close()">
                        <i class="ki-duotone ki-cross-circle fs-2"></i>
                        Tutup Tab
                    </button>
                </div>
                <!--end::Sticky Footer-->
            </div>

        </div>
    </div>


@endsection

@push('js')

@endpush
