@extends('content.page')
@section('title','List User')
@section('user','show')
@push('css')
    <link href="{{ url('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Pelamar List</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Pelamar Management</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Pelamar</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Pelamar List</li>
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
@push('css')
    <link href="{{ url('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="searchInput"
                                   class="form-control form-control-solid w-250px ps-13"
                                   placeholder="Cari pelamar..." />
                        </div>
                    </div>
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="table_pelamar">
                        <thead>
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Nama</th>
                            <th class="min-w-125px">Email</th>
                            <th class="min-w-125px">No HP</th>
                            <th class="min-w-125px">Last login</th>
                            <th class="min-w-125px">Joined Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-end min-w-100px">Actions</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Post-->
    </div>
@endsection

@push('js')

    <script src="{{ url('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <!--end::Custom Javascript-->
    @include('content.user.pelamar.data_pelamar')
@endpush
