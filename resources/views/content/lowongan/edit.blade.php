@extends('master')
@section('title','Edit Lowongan')
@section('lowongan','show')

@push('css')
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
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Lowongan Edit</h1>
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
                    <li class="breadcrumb-item text-gray-500">Lowongan Edit</li>
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
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
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
            <form id="kt_ecommerce_add_product_form"
                  action="{{ url('app/lowongan/update/' . $lowongan->id) }}"
                  method="POST"
                  class="form d-flex flex-column flex-lg-row">
                @csrf
                @method('PUT')

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">
                    <div class="card card-flush py-4">
                        <div class="card-header">
                            <div class="card-title">
                                <h2>General</h2>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <!-- Judul -->
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Judul Lowongan</label>
                                <input type="text" name="judul" value="{{ old('judul', $lowongan->judul) }}" class="form-control mb-2" required />
                            </div>

                            <!-- Lokasi -->
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Lokasi Penempatan</label>
                                <input type="text" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" class="form-control mb-2" required />
                            </div>

                            <!-- Bidang Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Bidang Pekerjaan</label>
                                <input type="text" name="bidang_pekerjaan" value="{{ old('bidang_pekerjaan', $lowongan->bidang_pekerjaan) }}" class="form-control mb-2" />
                            </div>

                            <!-- Jenis Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Jenis Pekerjaan</label>
                                <select name="jenis_pekerjaan" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option {{ old('jenis_pekerjaan', $lowongan->jenis_pekerjaan) == 'Full Time' ? 'selected' : '' }}>Full Time</option>
                                    <option {{ old('jenis_pekerjaan', $lowongan->jenis_pekerjaan) == 'Part Time' ? 'selected' : '' }}>Part Time</option>
                                    <option {{ old('jenis_pekerjaan', $lowongan->jenis_pekerjaan) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                                    <option {{ old('jenis_pekerjaan', $lowongan->jenis_pekerjaan) == 'Magang' ? 'selected' : '' }}>Magang</option>
                                </select>
                            </div>

                            <!-- Tipe Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Tipe Pekerjaan</label>
                                <select name="tipe_pekerjaan" class="form-select">
                                    <option value="Lowongan dalam negeri" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Lowongan dalam negeri' ? 'selected' : '' }}>Lowongan dalam negeri</option>
                                    <option value="Lowongan luar negeri" {{ old('tipe_pekerjaan', $lowongan->tipe_pekerjaan) == 'Lowongan luar negeri' ? 'selected' : '' }}>Lowongan luar negeri</option>
                                </select>
                            </div>

                            <!-- Jenis Kelamin -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki/Perempuan" {{ old('jenis_kelamin', $lowongan->jenis_kelamin) == 'Laki-laki/Perempuan' ? 'selected' : '' }}>Laki-laki/Perempuan</option>
                                    <option value="Laki-laki" {{ old('jenis_kelamin', $lowongan->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin', $lowongan->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>

                            <!-- Rentang Gaji -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Rentang Gaji</label>
                                <input type="text" name="rentang_gaji" value="{{ old('rentang_gaji', $lowongan->rentang_gaji) }}" class="form-control mb-2" />
                            </div>
                            <!-- Jumlah Lowongan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Jumlah Lowongan (orang)</label>
                                <input type="text" name="jumlah_lowongan" value="{{ old('jumlah_lowongan', $lowongan->jumlah_lowongan) }}" class="form-control mb-2" placeholder="Contoh: 1" />
                            </div>
                            <!-- Batas Lamaran -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Batas Lamaran</label>
                                <input type="date" name="batas_lamaran" value="{{ old('batas_lamaran', $lowongan->batas_lamaran ? date('Y-m-d', strtotime($lowongan->batas_lamaran)) : '') }}" class="form-control mb-2" />
                            </div>

                            <!-- Status -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Status Lowongan</label>
                                <select name="status" class="form-select">
                                    <option value="1" {{ old('status', $lowongan->status) == 1 ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('status', $lowongan->status) == 0 ? 'selected' : '' }}>Nonaktif</option>
                                </select>
                            </div>

                            <!-- Deskripsi Pekerjaan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Deskripsi Pekerjaan</label>
                                <textarea name="deskripsi_pekerjaan" id="deskripsi_pekerjaan" class="form-control" rows="6">{{ old('deskripsi_pekerjaan', $lowongan->deskripsi_pekerjaan) }}</textarea>
                            </div>

                            <!-- Persyaratan Khusus -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Persyaratan Khusus</label>
                                <textarea name="persyaratan_khusus" id="persyaratan_khusus" class="form-control" rows="5">{{ old('persyaratan_khusus', $lowongan->persyaratan_khusus) }}</textarea>
                            </div>

                            <!-- Pendidikan Minimal -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Pendidikan Minimal</label>
                                <select name="pendidikan_minimal" class="form-select">
                                    @foreach (['SD','SMP','SMA','D1','D2','D3','S1/D4','S2','S3'] as $p)
                                        <option value="{{ $p }}" {{ old('pendidikan_minimal', $lowongan->pendidikan_minimal) == $p ? 'selected' : '' }}>{{ $p }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status Pernikahan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Status Pernikahan</label>
                                <select name="status_pernikahan" class="form-select">
                                    <option value="Tidak Ada Preferensi" {{ old('status_pernikahan', $lowongan->status_pernikahan) == 'Tidak Ada Preferensi' ? 'selected' : '' }}>-- Tidak ada preferensi --</option>
                                    <option value="Belum" {{ old('status_pernikahan', $lowongan->status_pernikahan) == 'Belum' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="Nikah" {{ old('status_pernikahan', $lowongan->status_pernikahan) == 'Nikah' ? 'selected' : '' }}>Sudah Menikah</option>
                                </select>
                            </div>

                            <!-- Pengalaman Minimal -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Pengalaman Minimal (Tahun)</label>
                                <input type="number" name="pengalaman_minimal" value="{{ old('pengalaman_minimal', $lowongan->pengalaman_minimal) }}" class="form-control mb-2" min="0" />
                            </div>

                            <!-- Kondisi Fisik -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Kondisi Fisik</label>
                                <select name="kondisi_fisik" class="form-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="Non Disabilitas" {{ old('kondisi_fisik', $lowongan->kondisi_fisik) == 'Non Disabilitas' ? 'selected' : '' }}>Non Disabilitas</option>
                                    <option value="Disabilitas" {{ old('kondisi_fisik', $lowongan->kondisi_fisik) == 'Disabilitas' ? 'selected' : '' }}>Disabilitas</option>
                                </select>
                            </div>

                            <!-- Keterampilan -->
                            <div class="mb-10 fv-row">
                                <label class="form-label">Keterampilan</label>
                                <textarea name="keterampilan" id="keterampilan" class="form-control" rows="3">{{ old('keterampilan', $lowongan->keterampilan) }}</textarea>
                            </div>

                            <!-- Tombol Simpan -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Perbarui Lowongan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ url('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
    <script>
        ClassicEditor.create(document.querySelector('#deskripsi_pekerjaan')).catch(error => console.error(error));
        ClassicEditor.create(document.querySelector('#persyaratan_khusus')).catch(error => console.error(error));
        ClassicEditor.create(document.querySelector('#keterampilan')).catch(error => console.error(error));
    </script>
@endpush
