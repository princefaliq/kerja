@extends('master')
@section('title','Dashboard')
@section('dashboard','show')

@push('css')
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ url('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />

@endpush
@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl py-5">
            <!--begin::Row-->
            <div class="row gy-0 gx-10">
                <div class="col-xl-8">
                    <!--begin::Engage widget 2-->
                    <div class="card card-xl-stretch bg-body border-0 mb-5 mb-xl-0">
                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column flex-lg-row flex-stack p-lg-15">
                            <!--begin::Info-->
                            <div class="d-flex flex-column justify-content-center align-items-center align-items-lg-start me-10 text-center text-lg-start">
                                <!--begin::Title-->
                                <h3 class="fs-2hx line-height-lg mb-5">
                                    <span class="fw-bold">Solusi Pintar untuk </span>
                                    <br />
                                    <span class="fw-bold">Pencari Kerja</span>
                                </h3>
                                <!--end::Title-->
                                <div class="fs-4 text-muted mb-7">Jauh sebelum kamu duduk untuk mengetik
                                    <br />Perlu memastikan kamu bernapas.</div>
                                <a href='{{ url('app/lowongan') }}' class="btn btn-success fw-semibold px-6 py-3" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">Buat Lowongan</a>
                            </div>
                            <!--end::Info-->
                            <!--begin::Illustration-->
                            <img src="{{ url('assets/media/illustrations/sketchy-1/5.png') }}" alt="" class="mw-200px mw-lg-350px mt-lg-n10" />
                            <!--end::Illustration-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Engage widget 2-->
                </div>
                <div class="col-xl-4">
                    <!--begin::Mixed Widget 16-->
                    <div class="card card-xl-stretch bg-body border-0">
                        <!--begin::Body-->
                        <div class="card-body pt-5 mb-xl-9 position-relative">
                            <!--begin::Heading-->
                            <div class="d-flex flex-stack">
                                <!--begin::Title-->
                                <h4 class="fw-bold text-gray-800 m-0">Total Pelamar</h4>
                                <!--end::Title-->
                                <!--begin::Menu-->

                                <!--end::Menu-->
                            </div>
                            <!--end::Heading-->
                            <!--begin::Chart-->
                            <div class="d-flex flex-center mb-5 mb-xxl-0">
                                <div id="userPelamarChart" style="height: 260px; width: 100%;"></div>
                            </div>
                            <!--end::Chart-->
                            <!--begin::Content-->
                            <div class="text-center position-absolute bottom-0 start-50 translate-middle-x w-100 mb-10">
                                <!--begin::Text-->
                                <p class="fw-semibold fs-4 text-gray-500 mb-7 px-5">Perbandingan antara registrasi dan <br> mengisi biodata
                                    </p>
                                <!--end::Text-->
                                <!--begin::Action-->
                                @role('Admin')
                                <div class="m-0">
                                    <a href='{{ url('app/pelamar') }}' class="btn btn-success fw-semibold" >Pelamar</a>
                                </div>
                                @endrole
                                <!--ed::Action-->
                            </div>
                            <!--end::Content-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 16-->
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Row-->
            <div class="card card-xl-stretch bg-body border-0 mt-10 shadow-sm">
                <div class="card-body">
                    <div class="row gy-0 gx-10">
                        <!--begin::Col-->
                        <div class="col-xl-12">
                            <!--begin::General Widget 1-->
                            <div class="mb-10">
                                <!--begin::Tabs-->
                                <ul class="nav row mb-10" id="dashboardWidgets">
                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-warning  d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-security-user fs-2x mb-5 mx-0 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Total Register</span>
                                            <span class="fs-3 fw-bolder text-primary mt-2" id="countUser">0</span>
                                        </div>
                                    </li>
                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-success d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-office-bag fs-2x mb-5 mx-0 text-info">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Isi Biodata</span>
                                            <span class="fs-3 fw-bolder text-info mt-2" id="countPelamar">0</span>
                                        </div>
                                    </li>


                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-primary d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">

                                            <i class="ki-duotone ki-bank fs-2x mb-5 mx-0 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Perusahaan</span>
                                            <span class="fs-3 fw-bolder text-success mt-2" id="countPerusahaan">0</span>
                                        </div>
                                    </li>

                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-fingerprint-scanning text-warning fs-2x mb-5 mx-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                                <span class="path4"></span>
                                                <span class="path5"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Absen</span>
                                            <span class="fs-3 fw-bolder text-warning mt-2" id="countAbsen">0</span>
                                        </div>
                                    </li>
                                </ul>
                                <ul class="nav row mb-10" id="dashboardWidgets">
                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-success d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-brifecase-tick fs-2x mb-5 mx-0 text-info">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Melamar</span>
                                            <span class="fs-3 fw-bolder text-info mt-2" id="countMelamar">0</span>
                                        </div>
                                    </li>
                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-success d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-shield-cross fs-2x mb-5 mx-0 text-danger">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Ditolak</span>
                                            <span class="fs-3 fw-bolder text-danger mt-2" id="countTolak">0</span>
                                        </div>
                                    </li>
                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-danger d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-shield-tick fs-2x mb-5 mx-0 text-success">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Diterima</span>
                                            <span class="fs-3 fw-bolder text-success mt-2" id="countTerima">0</span>
                                        </div>
                                    </li>
                                    <li class="nav-item col-12 col-lg mb-5 mb-lg-0">
                                        <div class="nav-link btn btn-flex btn-color-gray-500 btn-outline btn-active-info d-flex flex-grow-1 flex-column flex-center py-5 h-125px h-lg-175px">
                                            <i class="ki-duotone ki-delivery-3 text-warning fs-2x mb-5 mx-0">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                            <span class="fs-6 fw-bold">Lowongan</span>
                                            <span class="fs-3 fw-bolder text-warning mt-2" id="countLowongan">0</span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--end::General Widget 1-->

                        </div>
                        <!--end::Col-->

                    </div>
                </div>
            </div>

            <div class="card card-xl-stretch bg-body border-0 mt-10 shadow-sm">
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title fw-bold fs-4">
                        Grafik Status Lamaran
                    </h3>
                </div>

                <div class="card-body">
                    <div id="statusLamaranChart" style="height: 350px;"></div>
                </div>
            </div>
            <!--end::Row-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@push('js')

   @include('content.dashboard.js_dashboard')
@endpush
