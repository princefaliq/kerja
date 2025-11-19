@extends('master')
@section('title','Create Acara')
@section('acara','show')

@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">

            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Create Acara</h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Acara Management</li>
                    <li class="breadcrumb-item text-gray-500">Create Acara</li>
                </ul>
            </div>

        </div>
    </div>
@endsection

@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">

        <div class="content flex-row-fluid" id="kt_content">

            {{-- Notifikasi Error --}}
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                    <strong>Terjadi kesalahan saat menyimpan data:</strong>
                    <ul class="mt-2 mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!--begin::Form-->
            <form action="{{ route('acara.store') }}" method="POST" class="form d-flex flex-column flex-lg-row">
                @csrf

                <div class="d-flex flex-column flex-row-fluid gap-7 gap-lg-10">

                    <div class="card card-flush py-4">

                        <div class="card-header">
                            <div class="card-title">
                                <h2>Data Acara</h2>
                            </div>
                        </div>

                        <div class="card-body pt-0">

                            {{-- Nama Acara --}}
                            <div class="mb-10 fv-row">
                                <label class="required form-label">Nama Acara</label>
                                <input type="text" name="nama_acara" class="form-control mb-2"
                                       placeholder="Contoh: Job Fair 2025"
                                       value="{{ old('nama_acara') }}" required>
                            </div>

                            {{-- Tanggal Mulai & Selesai --}}
                            <div class="row">
                                <div class="col-md-6 mb-10 fv-row">
                                    <label class="required form-label">Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control mb-2"
                                           value="{{ old('tanggal_mulai') }}" required>
                                </div>

                                <div class="col-md-6 mb-10 fv-row">
                                    <label class="required form-label">Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control mb-2"
                                           value="{{ old('tanggal_selesai') }}" required>
                                </div>
                            </div>

                            {{-- Waktu Mulai & Selesai --}}
                            <div class="row">
                                <div class="col-md-6 mb-10 fv-row">
                                    <label class="required form-label">Waktu Mulai</label>
                                    <input type="time" name="waktu_mulai" class="form-control mb-2"
                                           value="{{ old('waktu_mulai') }}" required>
                                </div>

                                <div class="col-md-6 mb-10 fv-row">
                                    <label class="required form-label">Waktu Selesai</label>
                                    <input type="time" name="waktu_selesai" class="form-control mb-2"
                                           value="{{ old('waktu_selesai') }}" required>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="mb-10 fv-row">
                                <label class="form-label">Deskripsi Acara</label>
                                <textarea name="deskripsi" rows="4" class="form-control"
                                          placeholder="Tuliskan informasi tambahan acara...">{{ old('deskripsi') }}</textarea>
                            </div>

                            {{-- Tombol Simpan --}}
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Simpan Acara</button>
                            </div>

                        </div>
                    </div>

                </div>
            </form>
            <!--end::Form-->

        </div>
    </div>
@endsection
