@extends('master')
@section('title','Create Lowongan')
@section('lowongan','show')

@push('css')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />

@endpush
@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Lowongan Create</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Lowongan Management</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Lowongan</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Lowongan Create</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->

            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            {{-- Notifikasi error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Terjadi kesalahan saat menyimpan data:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <!--begin::Form-->
            <form id="kt_ecommerce_add_product_form" action="{{ url('app/lowongan/store') }}" method="POST" class="form d-flex flex-column flex-lg-row" data-kt-redirect="{{ url('app/lowongan/store') }}">
                <!--begin::Aside column-->
                @csrf
                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <!--begin::Thumbnail settings-->
                    <div class="card card-flush py-4">
                        <!--begin::Card header-->
                        <div class="card-header">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <!-- Judul -->
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Judul Lowongan</label>
                                <input type="text" name="judul" class="form-control mb-2" placeholder="Contoh: SPB/SPG / Merchandiser" required />
                                <div class="text-muted fs-7">Judul lowongan harus unik dan mudah dipahami.</div>
                            </div>

                            <!-- Lokasi -->
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Lokasi Penempatan</label>
                                <input type="text" name="lokasi" class="form-control mb-2" placeholder="Contoh: Kab. Bantul, D.I. Yogyakarta" required />
                            </div>

                            <!-- Bidang Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Bidang Pekerjaan</label>
                                <input type="text" name="bidang_pekerjaan" class="form-control mb-2" placeholder="Contoh: Operasi Ritel" />
                            </div>

                            <!-- Jenis Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <select name="jenis_pekerjaan" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option>Full Time</option>
                                    <option>Part Time</option>
                                    <option>Freelance</option>
                                    <option>Magang</option>
                                </select>
                            </div>

                            <!-- Tipe Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Tipe Pekerjaan</label>
                                <select name="tipe_pekerjaan" class="form-select">
                                    <option value="Lowongan dalam negeri">Lowongan dalam negeri</option>
                                    <option value="Lowongan luar negeri">Lowongan luar negeri</option>
                                </select>
                                {{--<input type="text" name="tipe_pekerjaan" class="form-control mb-2" placeholder="Contoh: Lowongan dalam negeri" />--}}
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki/Perempuan">Laki-laki/Perempuan</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>

                            <!-- Rentang Gaji -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Rentang Gaji</label>
                                <input type="text" name="rentang_gaji" class="form-control mb-2" placeholder="Contoh: Rp3.000.000 - Rp5.000.000" />
                            </div>
                            <!-- Jumlah Lowongan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Jumlah Lowongan (orang)</label>
                                <input type="text" name="jumlah_lowongan" class="form-control mb-2" placeholder="Contoh: 1" />
                            </div>

                            <!-- Batas Lamaran -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Batas Lamaran</label>
                                <input type="date" name="batas_lamaran" class="form-control mb-2" />
                            </div>

                            <!-- Status -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Status Lowongan</label>
                                <select name="status" class="form-select">
                                    <option value="1">Aktif</option>
                                    <option value="0">Nonaktif</option>
                                </select>
                            </div>
                            <!-- Tipe Lowongan -->
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Tipe Lowongan</label>
                                <select name="tipe_lowongan" id="tipe_lowongan" class="form-select" required>
                                    <option value="non">Non Acara</option>
                                    <option value="acara">Acara / Jobfair</option>
                                </select>
                                <div class="text-muted fs-7">Pilih apakah lowongan ini bagian dari sebuah acara/jobfair.</div>
                            </div>

                            <!-- Pilih Acara -->
                            <div class="mb-10 fv-row" id="acara_wrapper" style="display:none;">
                                <label class="form-label">Pilih Acara</label>
                                <select name="acara_id" id="acara_id" class="form-select">
                                    <option value="">-- Pilih Acara --</option>
                                    @foreach ($acara as $item)
                                        <option value="{{ $item->id }}">
                                            {{ $item->nama_acara }} ({{ $item->tanggal_mulai }} s/d {{ $item->tanggal_selesai }})
                                        </option>
                                    @endforeach
                                </select>
                                <div class="text-muted fs-7">Lowongan hanya berlangsung selama acara berlangsung.</div>
                            </div>
                            <!-- Deskripsi Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Deskripsi Pekerjaan</label>
                                <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" class="form-control" rows="6"></textarea>
                                <div class="text-muted fs-7">Tulis deskripsi pekerjaan secara lengkap dan menarik.</div>
                            </div>

                            <!-- Persyaratan Khusus -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Persyaratan Khusus</label>
                                <textarea name="persyaratan_khusus" id="persyaratan_khusus" class="form-control" rows="5"></textarea>
                                <div class="text-muted fs-7">Tuliskan syarat-syarat khusus untuk pelamar.</div>
                            </div>

                            <!-- Pendidikan Minimal -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Pendidikan Minimal</label>
                                <select name="pendidikan_minimal" class="form-select">
                                    <option value="">-- Pilih Pendidikan --</option>
                                    <option value="SD">SD / Sederajat</option>
                                    <option value="SMP">SMP / Sederajat</option>
                                    <option value="SMA">SMA / Sederajat</option>
                                    <option value="D1">D1 / Sederajat</option>
                                    <option value="D2">D2 / Sederajat</option>
                                    <option value="D3">D3 / Sederajat</option>
                                    <option value="S1/D4">S1 / D4</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>

                            <!-- Status Pernikahan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Status Pernikahan</label>
                                <select name="status_pernikahan" class="form-select">
                                    <option value="Tidak Ada Preferensi">-- Tidak ada preferensi --</option>
                                    <option value="Belum">Belum Menikah</option>
                                    <option value="Nikah">Sudah Menikah</option>
                                </select>
                            </div>

                            <!-- Pengalaman Minimal -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Pengalaman Minimal (Tahun)</label>
                                <input type="number" name="pengalaman_minimal" class="form-control mb-2" min="0" placeholder="Contoh: 1" />
                            </div>

                            <!-- Kondisi Fisik -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Kondisi Fisik</label>
                                <select name="kondisi_fisik" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Non Disabilitas">Non Disabilitas</option>
                                    <option value="Disabilitas">Disabilitas</option>
                                </select>
                            </div>

                            <!-- Keterampilan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Keterampilan</label>
                                <textarea name="keterampilan" id="keterampilan" class="form-control" rows="3"></textarea>
                                <div class="text-muted fs-7">Tuliskan keterampilan yang dibutuhkan pelamar.</div>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan Lowongan</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
    <!--end::Container-->
@endsection
@push('js')
    <script src="{{ url('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#deskripsi_pekerjaan'))
            .catch(error => console.error(error));

        ClassicEditor
            .create(document.querySelector('#persyaratan_khusus'))
            .catch(error => console.error(error));

        ClassicEditor
            .create(document.querySelector('#keterampilan'))
            .catch(error => console.error(error));

        // Tampilkan/sembunyikan select acara
        document.getElementById('tipe_lowongan').addEventListener('change', function () {
            if (this.value === 'acara') {
                document.getElementById('acara_wrapper').style.display = 'block';
            } else {
                document.getElementById('acara_wrapper').style.display = 'none';
                document.getElementById('acara_id').value = "";
            }
        });

    </script>
@endpush


