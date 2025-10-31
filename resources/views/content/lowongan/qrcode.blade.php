@extends('master')
@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Lowongan List</h1>
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
                    <li class="breadcrumb-item text-gray-500">Lowongan QR COde</li>
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
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <h3 class="mb-4 text-primary">QR Code Lowongan</h3>
                    </div>
                    <!--end::Card title-->

                </div>
                <div class="card-body pt-0">
                    <div class="container text-center mt-5">
                        <div class="card p-4 shadow-sm d-inline-block">
                            <h5 class="mb-2">{{ $lowongan->judul }}</h5>
                            <p class="text-muted mb-3">{{ $url }}</p>

                            <div>{!! $svg !!}</div>

                            <div class="mt-4">
                                <a href="{{ route('lowongan.qrcode.download', $lowongan->slug) }}"
                                   class="btn btn-success">
                                    <i class="bi bi-download me-1"></i> Download QR Code
                                </a>
                                <button type="button" class="btn btn-light" onclick="window.close()">Tutup Tab</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

