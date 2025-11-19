
@extends('master')
@section('title','Acara')
@section('acara','show')

@push('css')
    <link href="{{ url('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Daftar Acara</h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Manajemen Acara</li>
                    <li class="breadcrumb-item text-gray-500">Daftar Acara</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">

            <div class="card card-flush">

                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4"></i>
                            <input type="text" data-acara-search class="form-control form-control-solid w-250px ps-12" placeholder="Search Acara" />
                        </div>
                    </div>

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ url('app/acara/create') }}" class="btn btn-primary">
                            Add Acara
                        </a>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tableAcara">
                        <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">#</th>
                            <th class="min-w-200px">Nama Acara</th>
                            <th class="min-w-100px text-end">Tanggal</th>
                            <th class="min-w-100px text-end">Waktu Mulai</th>
                            <th class="min-w-100px text-end">Waktu Selesai</th>
                            <th class="min-w-70px text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600"></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    @include('content.acara.data_acara')
@endpush
