@extends('master')
@section('title','Detil Pelamar')
@section('lamaran','show')

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
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Detil Pelamar</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Lamaran Management</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Lamaran</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Detil Pelamar</li>
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
            <!--begin::Products-->
            <div class="card card-flush border-0 shadow-sm rounded-4">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                         <h2><i class="bi bi-person-vcard-fill fs-2 text-info me-2"></i>BIODATA</h2>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body p-0 ">
                    <!--begin::Table-->
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <!-- Bagian Header Profil -->
                                <div class="text-center mb-4">
                                    <div class="text-center mb-4 position-relative">
                                        <img id="foto-profil"
                                            src="{{ $profile->user->avatarUrl ? url($profile->user->avatarUrl) : 'https://placehold.co/600x756' }}"
                                            alt="Foto Profil"
                                            class="border rounded shadow-sm border-3 imageAvatar"
                                            height="220">
                                    </div>

                                    <div class="position-relative d-inline-block">
                                        <!-- Teks nama -->
                                        <h1 id="display-nama" class="fw-bold text-dark mb-1 d-inline-block">
                                            {{ $profile->user->name }}
                                        </h1>
                                    </div>
                                </div>
                               <div class="separator border-info my-10"></div>
                                    

                                <!-- Bagian Informasi Dasar -->

                                <div class="row fs-2 text-center mb-5">
                                    <div class="col-md-4 mb-3">
                                        <i class="bi bi-person-badge-fill text-info fs-2 me-2"></i>
                                        <span id="data-nik" class="fw-medium text-dark">{{ $profile->nik }}</span>
                                        <p class="text-info small m-0">NIK</p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <i class="bi bi-calendar-date-fill text-info fs-2 me-2"></i>
                                        <span id="data-tanggal" class="fw-medium text-dark">
                                            {{ \Carbon\Carbon::parse($profile->tgl_lahir)->locale('id')->isoFormat('DD MMMM YYYY') }}
                                            ( {{\Carbon\Carbon::parse($profile->tgl_lahir)->age  }} tahun)
                                        </span>
                                        <p class="text-info small m-0">Tanggal Lahir</p>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        @if ($profile->jenis_kelamin == 'laki-laki')
                                            <i class="bi bi-gender-male fs-2 text-info me-2"></i>
                                        @else
                                            <i class="bi bi-gender-female fs-2 text-info me-2"></i>    
                                        @endif
                                        
                                        <span id="data-jk" class="fw-medium text-dark">{{ ucfirst($profile->jenis_kelamin) }}</span>
                                        <p class="text-info small m-0">Jenis Kelamin</p>
                                    </div>
                                </div>

                                <div class="row fs-2 text-center mb-5">
                                    <div class="col-md-6 mb-3">
                                        @if ($profile->status_pernikahan == 'Kawin')
                                            <i class="bi bi-heart-fill fs-2 text-info me-2"></i>
                                        @else
                                            <i class="bi bi-heartbreak-fill fs-2 text-info me-2"></i> 
                                        @endif
                                        
                                        <span id="data-status" class="fw-medium text-dark">{{ $profile->status_pernikahan }}</span>
                                        <p class="text-info small m-0">Status Pernikahan</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        @if ($profile->disabilitas == 'iya')
                                            <i class="bi bi-person-wheelchair fs-2 text-info me-2"></i>
                                        @else
                                            <i class="bi bi-person-walking fs-2 text-info me-2"></i> 
                                        @endif
                                        <span id="data-disabilitas" class="fw-medium text-dark">{{ ucfirst($profile->disabilitas) }}</span>
                                        <p class="text-info small m-0">Disabilitas</p>
                                    </div>
                                </div>

                                <!-- Alamat Lengkap -->
                                <div class="mb-4 text-center fs-2 mb-5">
                                    <i class="bi bi-geo-alt-fill fs-2 text-info me-2"></i>
                                    <span id="data-alamat" class="fw-medium text-dark">
                                        {{ $profile->provinsi }}, {{ $profile->kabupaten }}, {{ $profile->kecamatan }},
                                        {{ $profile->desa }}, {{ $profile->alamat }}
                                    </span>
                                    <p class="text-info small m-0">Alamat Lengkap</p>
                                </div>

                                <div class="separator border-info my-10"></div>
                                <!-- Bagian Dokumen -->
                                <h1 class="fw-bold text-dark mb-3 fs-2 text-center">
                                    <i class="bi bi-archive-fill fs-2 text-info me-2"></i>
                                    Dokumen Pelamar
                                </h1>
                                <div class="row text-center">
                                    <div class="col-md-12 m-10">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-credit-card-fill fs-2 me-2 text-info"></i>
                                            <h2 class="mb-0"> Kartu Tanda Penduduk </h2>
                                        </div>
                                        @if(!empty($profile->ktpUrl))
                                            <iframe src="{{ url($profile->ktpUrl) }}" width="80%" height="500px" 
                                            style="border:1px solid #ddd; border-radius: 6px;"></iframe>
                                        @else
                                               <span class="text-warning fs-2"><i class="bi bi-sign-stop-fill text-danger fs-2 me-1"></i> Kartu Tanda Penduduk (tidak tersedia)</span> 
                                        @endif
                                        
                                        
                                    </div>
                                    <div class="col-md-12 m-10">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-file-earmark-zip-fill     fs-2 me-2 text-info"></i>
                                            <h2 class="mb-0"> Curriculum vitae </h2>
                                        </div>
                                        @if(!empty($profile->cvUrl))
                                            <iframe src="{{ url($profile->cvUrl) }}" width="80%" height="500px" 
                                            style="border:1px solid #ddd; border-radius: 6px;"></iframe>
                                        @else
                                               <span class="text-warning fs-2"><i class="bi bi-sign-stop-fill text-danger fs-2 me-1"></i> Curriculum vitae (tidak tersedia)</span> 
                                        @endif
                                        
                                        
                                    </div>
                                    <div class="col-md-12 m-10">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-mortarboard-fill fs-2 me-2 text-info"></i>
                                            <h2 class="mb-0"> Ijazah </h2>
                                        </div>
                                        @if(!empty($profile->ijazahUrl))
                                            <iframe src="{{ url($profile->ijazahUrl) }}" width="80%" height="500px" 
                                            style="border:1px solid #ddd; border-radius: 6px;"></iframe>
                                        @else
                                               <span class="text-warning fs-2"><i class="bi bi-sign-stop-fill text-danger fs-2 me-1"></i> Ijazah (tidak tersedia)</span> 
                                        @endif
                                        
                                        
                                    </div>
                                    <div class="col-md-12 m-10">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-briefcase-fill fs-2 me-2 text-info"></i>
                                            <h2 class="mb-0"> Kartu Tanda Pencari Kerja </h2>
                                        </div>
                                        @if(!empty($profile->ak1Url))
                                            <iframe src="{{ url($profile->ak1Url) }}" width="80%" height="500px" 
                                            style="border:1px solid #ddd; border-radius: 6px;"></iframe>
                                        @else
                                               <span class="text-warning fs-2"><i class="bi bi-sign-stop-fill text-danger fs-2 me-1"></i> Kartu Tanda Pencari Kerja (tidak tersedia)</span> 
                                        @endif
                                        
                                        
                                    </div>
                                    <div class="col-md-12 m-10">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-award-fill fs-2 me-2 text-info"></i>
                                            <h2 class="mb-0"> Sertifikat </h2>
                                        </div>
                                        @if(!empty($profile->sertifikatUrl))
                                            <iframe src="{{ url($profile->sertifikatUrl) }}" width="80%" height="500px" 
                                            style="border:1px solid #ddd; border-radius: 6px;"></iframe>
                                        @else
                                               <span class="text-warning fs-2"><i class="bi bi-sign-stop-fill text-danger fs-2 me-1"></i> Sertifikat (tidak tersedia)</span> 
                                        @endif
                                    </div>

                                    <div class="col-md-12 m-10">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="bi bi-clipboard-plus-fill fs-2 me-2 text-info"></i>
                                            <h2 class="mb-0"> Syarat Lain </h2>
                                        </div>
                                        @if(!empty($profile->syarat_lainUrl))
                                            <iframe src="{{ url($profile->syarat_lainUrl) }}" width="80%" height="500px" 
                                            style="border:1px solid #ddd; border-radius: 6px;"></iframe>
                                        @else
                                               <span class="text-warning fs-2"><i class="bi bi-sign-stop-fill text-danger fs-2 me-1"></i> Syarat Lain (tidak tersedia)</span> 
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@push('js')
    @include('content.lamaran.data_lamaran')
@endpush

