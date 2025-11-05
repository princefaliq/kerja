@extends('crafto.master')
@section('title','Profile Pelamar')
@push('css')
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet"/>
    <style>
        .icon-hover {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .icon-hover:hover {
            color: var(--golden-yellow); /* ubah warna ikon */
            transform: scale(1.2); /* sedikit membesar */
        }
    </style>
    <style>
        /* ============================= */
        /* CARD TAMBAHAN */
        /* ============================= */
        .card-custom {
            min-height: 400px;
            max-height: 400px;
            overflow-y: auto;
        }

        /* ============================= */
        /* HASIL CROP FOTO */
        /* ============================= */
        #hasilCrop {
            border: 3px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            margin-top: 10px;
            max-width: 150px;
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.5s ease, transform 0.3s ease;
            display: none;
        }

        /* Saat hasilCrop aktif (sudah diisi src) */
        #hasilCrop.active {
            display: block;
            opacity: 1;
            transform: scale(1);
        }

        #hasilCrop:hover {
            transform: scale(1.05);
        }
        .imageAvatar:hover {
            transform: scale(1.05);
        }
        /* ============================= */
        /* MODAL CROPPER */
        /* ============================= */
        .crop-container {
            width: 100%;
            max-height: 80vh;
            overflow: hidden;
            background-color: #222;
        }

        #previewFoto {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
@endpush
@section('content')
    <section class="bg-dark-midnight-blue text-light pt-8 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li>Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @if (session('success'))
        <div class="alert alert-success box-shadow-extra-large bg-white alert-dismissable">
            <a href="#" class="close" data-bs-dismiss="alert" aria-label="close"><i class="fa-solid fa-xmark"></i></a>
            <strong>Success!</strong> {{ session('success') }}.
        </div>
    @endif
    <section class="pt-60px pb-0 md-pt-30px">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                        <!-- Bagian Header Profil -->
                        <div class="text-center mb-4">
                            <div class="text-center mb-4 position-relative">
                                <img id="foto-profil"
                                     src="{{ $profile->user->avatarUrl ? url($profile->user->avatarUrl) : 'https://placehold.co/600x756' }}"
                                     alt="Foto Profil"
                                     class="border rounded shadow-sm border-3 imageAvatar"
                                     width="120" height="120">

                                <button type="button" class="btn btn-sm position-absolute" id="btnEditFoto">
                                    <i class="bi bi-pencil-square text-base-color icon-hover text-base-color"></i>
                                </button>
                            </div>

                            <div class="position-relative d-inline-block">
                                <!-- Teks nama -->
                                <h4 id="display-nama" class="fw-bold text-dark mb-1 d-inline-block">
                                    {{ $profile->user->name }}
                                </h4>

                                <!-- Input edit nama (disembunyikan dulu) -->
                                <input type="text" id="input-nama"
                                       class="form-control form-control-sm d-none"
                                       value="{{ $profile->user->name }}"
                                       style="max-width: 250px; display: inline-block;">

                                <!-- Tombol edit / simpan -->
                                <button type="button" class="btn btn-sm position-absolute" title="Edit Nama" id="btnEditNama">
                                    <i class="bi bi-pencil-square text-base-color icon-hover text-base-color"></i>
                                </button>
                            </div>

                            <p class="text-muted mb-2">
                                <i class="feather icon-feather-log-in text-golden-yellow me-1"></i>
                                Terakhir login:
                                {{ $profile->user->last_login ? $profile->user->last_login->diffForHumans() : '-' }}
                            </p>
                        </div>

                        <!-- Garis pemisah -->
                        <div class="d-flex align-items-center justify-content-between my-3 position-relative">
                            <hr class="flex-grow-1 my-0">
                            <button type="button" class="btn btn-sm ms-2 border-0 bg-transparent" title="Edit Biodata" id="btnEditData">
                                <i class="bi bi-pencil-square text-base-color icon-hover text-base-color"></i>
                            </button>
                        </div>

                        <!-- Bagian Informasi Dasar -->
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <i class="feather icon-feather-user text-golden-yellow me-2"></i>
                                <span id="data-nik" class="fw-medium text-dark">{{ $profile->nik }}</span>
                                <p class="text-secondary small m-0">NIK</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="feather icon-feather-calendar text-golden-yellow me-2"></i>
                                <span id="data-tanggal" class="fw-medium text-dark">
                                    {{ \Carbon\Carbon::parse($profile->tgl_lahir)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                </span>
                                <p class="text-secondary small m-0">Tanggal Lahir</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="feather icon-feather-users text-golden-yellow me-2"></i>
                                <span id="data-jk" class="fw-medium text-dark">{{ ucfirst($profile->jenis_kelamin) }}</span>
                                <p class="text-secondary small m-0">Jenis Kelamin</p>
                            </div>
                        </div>

                        <div class="row text-center">
                            <div class="col-md-6 mb-3">
                                <i class="feather icon-feather-heart text-golden-yellow me-2"></i>
                                <span id="data-status" class="fw-medium text-dark">{{ $profile->status_pernikahan }}</span>
                                <p class="text-secondary small m-0">Status Pernikahan</p>
                            </div>
                            <div class="col-md-6 mb-3">
                                <i class="feather icon-feather-alert-octagon text-golden-yellow me-2"></i>
                                <span id="data-disabilitas" class="fw-medium text-dark">{{ ucfirst($profile->disabilitas) }}</span>
                                <p class="text-secondary small m-0">Disabilitas</p>
                            </div>
                        </div>

                        <!-- Alamat Lengkap -->
                        <div class="mb-4 text-center">
                            <i class="feather icon-feather-map-pin text-golden-yellow me-2"></i>
                            <span id="data-alamat" class="fw-medium text-dark">
                                {{ $profile->provinsi }}, {{ $profile->kabupaten }}, {{ $profile->kecamatan }},
                                {{ $profile->desa }}, {{ $profile->alamat }}
                            </span>
                            <p class="text-secondary small m-0">Alamat Lengkap</p>
                        </div>

                        <!-- Garis pemisah -->
                        <div class="d-flex align-items-center justify-content-between my-3 position-relative">
                            <hr class="flex-grow-1 my-0">
                            <button type="button" class="btn btn-sm ms-2 border-0 bg-transparent" title="Edit Pendidikan" id="btnEditPendidikan">
                                <i class="bi bi-pencil-square text-base-color icon-hover text-base-color"></i>
                            </button>
                        </div>

                        <!-- Bagian Pendidikan -->
                        <h6 class="fw-bold text-dark mb-3 text-center">
                            <i class="feather icon-feather-book text-golden-yellow me-2"></i>
                            Pendidikan Terakhir
                        </h6>
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <i class="feather icon-feather-bookmark text-golden-yellow me-2"></i>
                                <span id="data-pendidikan" class="fw-medium text-dark">{{ $profile->pendidikan_terahir ?? '-' }}</span>
                                <p class="text-secondary small m-0">Tingkat Pendidikan</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="feather icon-feather-layers text-golden-yellow me-2"></i>
                                <span id="data-jurusan" class="fw-medium text-dark">{{ $profile->jurusan ?? '-' }}</span>
                                <p class="text-secondary small m-0">Jurusan</p>
                            </div>
                            <div class="col-md-4 mb-3">
                                <i class="feather icon-feather-home text-golden-yellow me-2"></i>
                                <span id="data-namasekolah" class="fw-medium text-dark">{{ $profile->nama_sekolah ?? '-' }}</span>
                                <p class="text-secondary small m-0">Nama Sekolah / Universitas</p>
                            </div>
                        </div>

                        <!-- Garis pemisah -->
                        <div class="d-flex align-items-center justify-content-between my-3 position-relative">
                            <hr class="flex-grow-1 my-0">
                            <button type="button" class="btn btn-sm ms-2 border-0 bg-transparent" title="Edit Dokumen" id="btnEditDokumen">
                                <i class="bi bi-pencil-square text-base-color icon-hover text-base-color"></i>
                            </button>
                        </div>

                        <!-- Bagian Dokumen -->
                        <h6 class="fw-bold text-dark mb-3 text-center">
                            <i class="feather icon-feather-file-text text-golden-yellow me-2"></i>
                            Dokumen Pelamar
                        </h6>

                        <div class="row text-center">
                            <div class="col-md-4 mb-2">
                                <a href="{{ url($profile->ktpUrl) }}" target="_blank" class="text-dark text-decoration-none">
                                    <i class="feather icon-feather-file text-golden-yellow me-1"></i> KTP
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                <a href="{{ url($profile->cvUrl) }}" target="_blank" class="text-dark text-decoration-none">
                                    <i class="feather icon-feather-file-text text-golden-yellow me-1"></i> CV
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                <a href="{{ url($profile->ijazahUrl) }}" target="_blank" class="text-dark text-decoration-none">
                                    <i class="feather icon-feather-book text-golden-yellow me-1"></i> Ijazah dan Transkrip
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                <a href="{{ url($profile->ak1Url) }}" target="_blank" class="text-dark text-decoration-none">
                                    <i class="feather icon-feather-credit-card text-golden-yellow me-1"></i> Kartu Tanda Pencari Kerja (AK1)
                                </a>
                            </div>
                            <div class="col-md-4 mb-2">
                                @if(!empty($profile->sertifikatUrl))
                                    <a href="{{ url($profile->sertifikatUrl) }}" target="_blank" class="text-dark text-decoration-none">
                                        <i class="feather icon-feather-award text-golden-yellow me-1"></i> Sertifikat
                                    </a>
                                    <button type="button" class="btn btn-sm border-0 bg-transparent btnHapus" title="Hapus Sertifikat" data-field="sertifikat">
                                        <i class="bi bi-x-square text-danger icon-hover"></i>
                                    </button>
                                @else
                                    <span class="text-muted"><i class="feather icon-feather-award me-1"></i> Sertifikat (tidak tersedia)</span>
                                @endif
                            </div>
                            <div class="col-md-4 mb-2">
                                @if(!empty($profile->syarat_lainUrl))
                                    <a href="{{ url($profile->syarat_lainUrl) }}" target="_blank" class="text-dark text-decoration-none">
                                        <i class="feather icon-feather-clipboard text-golden-yellow me-1"></i> Syarat Lain
                                    </a>
                                    <button type="button" class="btn btn-sm border-0 bg-transparent btnHapus" title="Hapus Syarat Lain" data-field="syarat_lain">
                                        <i class="bi bi-x-square text-danger icon-hover"></i>
                                    </button>
                                @else
                                    <span class="text-muted"><i class="feather icon-feather-clipboard me-1"></i> Syarat Lain (tidak tersedia)</span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- ============================= -->
    <!-- MODAL CROPPER FULLSCREEN -->
    <!-- ============================= -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- modal lebih lebar -->
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Foto 3x4</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="background-color: #222;">
                    <div class="crop-container" style="width: 100%; max-height: 80vh; overflow: hidden;">
                        <img id="previewFoto" style="width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnCrop" class="btn btn-success">Crop & Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- MODAL BIODATA -->
    <!-- ============================= -->
    <div class="modal fade" id="editDataModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Pribadi</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditData">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label class="form-label">NIK</label>
                                <input type="text" name="nik" class="form-control" value="{{ $profile->nik }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="tgl_lahir" class="form-control" value="{{ $profile->tgl_lahir }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="laki-laki" {{ $profile->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ $profile->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status Pernikahan</label>
                                <select name="status_pernikahan" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Belum Kawin" {{ $profile->status_pernikahan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ $profile->status_pernikahan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Disabilitas</label>
                                <input type="text" name="disabilitas" class="form-control" value="{{ $profile->disabilitas }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="provinsi" class="form-label">Provinsi</label>
                                <select id="provinsi" name="provinsi" class="form-select"
                                        data-selected="{{ $profile->provinsi ?? '' }}">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kabupaten" class="form-label">Kabupaten</label>
                                <select id="kabupaten" name="kabupaten" class="form-select"
                                        data-selected="{{ $profile->kabupaten ?? '' }}">
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <select id="kecamatan" name="kecamatan" class="form-select"
                                        data-selected="{{ $profile->kecamatan ?? '' }}">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="desa" class="form-label">Desa/Kelurahan</label>
                                <select id="desa" name="desa" class="form-select"
                                        data-selected="{{ $profile->desa ?? '' }}">
                                    <option value="">Pilih Desa/Kelurahan</option>
                                </select>
                            </div>

                            <div class="col-12 mb-3">
                                <label for="alamat" class="form-label">Alamat Detail</label>
                                <textarea name="alamat" id="alamat" class="form-control">{{ $profile->alamat }}</textarea>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" id="btnSimpanData">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- MODAL EDIT DOKUMEN -->
    <!-- ============================= -->
    <div class="modal fade" id="modalEditDokumen" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Dokumen Pelamar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <form id="formEditDokumen" enctype="multipart/form-data">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">KTP</label>
                                <input type="file" name="ktp" accept=".pdf" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">CV</label>
                                <input type="file" name="cv" accept=".pdf" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ijazah</label>
                                <input type="file" name="ijazah" accept=".pdf" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">AK1</label>
                                <input type="file" name="ak1" accept=".pdf" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Sertifikat</label>
                                <input type="file" name="sertifikat" accept=".pdf" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Syarat Lain</label>
                                <input type="file" name="syarat_lain" accept=".pdf" class="form-control">
                            </div>
                        </div>
                    </form>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" id="btnSimpanDokumen">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================= -->
    <!-- MODAL EDIT PENDIDIKAN -->
    <!-- ============================= -->
    <div class="modal fade" id="editPendidikanModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pendidikan Terakhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditPendidikan">
                        @csrf
                        <div class="row g-3">

                            <div class="col-md-12">
                                <label class="form-label">Pendidikan Terakhir</label>
                                <select name="pendidikan_terahir" class="form-select">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="SD" {{ $profile->pendidikan_terahir == 'SD' ? 'selected' : '' }}>SD</option>
                                    <option value="SMP" {{ $profile->pendidikan_terahir == 'SMP' ? 'selected' : '' }}>SMP</option>
                                    <option value="SMA" {{ $profile->pendidikan_terahir == 'SMA' ? 'selected' : '' }}>SMA</option>
                                    <option value="SMK" {{ $profile->pendidikan_terahir == 'SMK' ? 'selected' : '' }}>SMK</option>
                                    <option value="D1" {{ $profile->pendidikan_terahir == 'D1' ? 'selected' : '' }}>D1</option>
                                    <option value="D2" {{ $profile->pendidikan_terahir == 'D2' ? 'selected' : '' }}>D2</option>
                                    <option value="D3" {{ $profile->pendidikan_terahir == 'D3' ? 'selected' : '' }}>D3</option>
                                    <option value="S1/D4" {{ $profile->pendidikan_terahir == 'S1/D4' ? 'selected' : '' }}>S1/D4</option>
                                    <option value="S2" {{ $profile->pendidikan_terahir == 'S2' ? 'selected' : '' }}>S2</option>
                                    <option value="S3" {{ $profile->pendidikan_terahir == 'S3' ? 'selected' : '' }}>S3</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control"
                                       value="{{ $profile->jurusan ?? '' }}" placeholder="Contoh: Rekayasa Perangkat Lunak">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Nama Sekolah / Perguruan Tinggi</label>
                                <input type="text" name="nama_sekolah" class="form-control"
                                       value="{{ $profile->nama_sekolah ?? '' }}" placeholder="Contoh: SMKN 1 Bondowoso">
                            </div>

                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-success" id="btnSimpanPendidikan">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </div>



@endsection
@include('crafto.js_profile')

