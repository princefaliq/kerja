@extends('master')
@section('title','Informasi')
@section('informasi','show')

@push('css')
    <link href="{{ url('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">

            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Informasi List</h1>

                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Informasi Management</li>
                    <li class="breadcrumb-item text-gray-600">Informasi</li>
                    <li class="breadcrumb-item text-gray-500">Informasi List</li>
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
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text"
                                   data-kt-informasi-filter="search"
                                   class="form-control form-control-solid w-250px ps-12"
                                   placeholder="Search Informasi" />
                        </div>
                    </div>

                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">

                        <div class="w-100 mw-150px">
                            <select class="form-select form-select-solid"
                                    data-control="select2"
                                    data-hide-search="true"
                                    data-placeholder="Status"
                                    data-kt-informasi-filter="status">
                                <option value="">Semua</option>
                                <option value="1">Active</option>
                                <option value="0">Non Active</option>
                            </select>
                        </div>

                        <a href="{{ route('informasi.create') }}"
                           class="btn btn-primary">
                            Add Informasi
                        </a>

                    </div>

                </div>

                <div class="card-body pt-0">

                    <table class="table align-middle table-row-dashed fs-6 gy-5"
                           id="dataInformasi">

                        <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">

                            <th class="w-10px pe-2">
                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           data-kt-check="true"
                                           data-kt-check-target="#dataInformasi .form-check-input"
                                           value="1" />
                                </div>
                            </th>

                            <th class="min-w-80px">Gambar</th>
                            <th class="min-w-250px">Judul</th>
                            <th class="min-w-120px">Urutan</th>
                            <th class="min-w-150px">Publish</th>
                            <th class="min-w-100px">Status</th>
                            <th class="text-center min-w-100px">Actions</th>

                        </tr>
                        </thead>

                        <tbody class="fw-semibold text-gray-600">

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>
@endsection

@push('js')
    @include('content.informasi.data_informasi')
@endpush
