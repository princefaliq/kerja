@extends('master')
@section('title','My Profile')
@section('profile','show')

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
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Account Overview</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Account</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Edit Account</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">My Profile</li>
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
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ url(\Illuminate\Support\Facades\Auth::user()->avatar_url) }}" alt="{{\Illuminate\Support\Facades\Auth::user()->name }}" />
                                <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                            </div>
                        </div>
                        <!--end::Pic-->
                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{\Illuminate\Support\Facades\Auth::user()->name }}</a>
                                        <a href="#">
                                            <i class="ki-duotone ki-verify fs-1 text-primary">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </a>
                                    </div>
                                    <!--end::Name-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>{{ \Illuminate\Support\Facades\Auth::user()->getRoleNames()->first() }}</a>
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-geolocation fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            @if(auth()->check() && auth()->user()->perusahaan)
                                                {{ auth()->user()->perusahaan->alamat }}
                                            @endif
                                        </a>
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>{{ \Illuminate\Support\Facades\Auth::user()->email }}</a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->

                            </div>
                            <!--end::Title-->
                            <!--begin::Stats-->
                            <div class="d-flex flex-wrap flex-stack">
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-column flex-grow-1 pe-8">
                                    <!--begin::Stats-->
                                    <div class="d-flex flex-wrap">
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-prefix="$">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">Earnings</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="80">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">Projects</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                        <!--begin::Stat-->
                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="%">0</div>
                                            </div>
                                            <!--end::Number-->
                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">Success Rate</div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Wrapper-->

                            </div>
                            <!--end::Stats-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->
                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ url('app/myprofile') }}">Profile</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="{{ url('app/myprofile/edit') }}">Edit</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ url('app/myprofile/lowongan') }}">Lowongan</a>
                        </li>
                        <!--end::Nav item-->
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="{{ url('app/myprofile/qrcode') }}">QR Code</a>
                        </li>
                        <!--end::Nav item-->
                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::details View-->
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <!--begin::Card header-->
                <div class="card-header cursor-pointer">
                    <!--begin::Card title-->
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                    <!--end::Card title-->
                    <!--begin::Action-->

                    <!--end::Action-->
                </div>
                <!--begin::Card header-->
                <!--begin::Card body-->
                <div id="kt_account_settings_profile_details" class="collapse show">
                    <!--begin::Form-->
                    <form class="form" action="{{ route('myprofile.update') }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">

                            {{-- Avatar --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Logo / Avatar</label>
                                <div class="col-lg-8">
                                    <div class="image-input image-input-outline" data-kt-image-input="true"
                                         style="background-image: url('{{ asset('assets/media/svg/avatars/blank.svg') }}')">

                                        <!--begin::Preview existing avatar-->
                                        <div class="image-input-wrapper w-125px h-125px"
                                             style="background-image: url('{{ $perusahaan->user->avatar
                                                ? asset($perusahaan->user->avatar_url)
                                                : asset('assets/media/avatars/blank.png') }}')">
                                        </div>
                                        <!--end::Preview existing avatar-->

                                        <!--begin::Change-->
                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                               data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change logo">
                                            <i class="ki-duotone ki-pencil fs-7">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                            <input type="hidden" name="avatar_remove" />
                                        </label>
                                        <!--end::Change-->

                                        <!--begin::Cancel-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                              data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Cancel-->

                                        <!--begin::Remove-->
                                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                              data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                            <i class="ki-duotone ki-cross fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                        <!--end::Remove-->
                                    </div>
                                    <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                </div>
                            </div>

                            {{-- Nama & Email --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Nama & Email</label>
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6 fv-row">
                                            <input type="text" name="name"
                                                   class="form-control form-control-lg form-control-solid mb-3 mb-lg-0"
                                                   placeholder="Nama perusahaan"
                                                   value="{{ old('name', $perusahaan->user->name) }}" />
                                        </div>
                                        <div class="col-lg-6 fv-row">
                                            <input type="email" name="email"
                                                   class="form-control form-control-lg form-control-solid"
                                                   placeholder="Email"
                                                   value="{{ old('email', $perusahaan->user->email) }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- No HP --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor HP</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="no_hp"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="Nomor HP"
                                           value="{{ old('no_hp', $perusahaan->user->no_hp) }}" />
                                </div>
                            </div>

                            {{-- Bidang --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Bidang Usaha</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="bidang"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="Bidang usaha"
                                           value="{{ old('bidang', $perusahaan->bidang) }}" />
                                </div>
                            </div>

                            {{-- Website --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Website</label>
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="website"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="https://example.com"
                                           value="{{ old('website', $perusahaan->website) }}" />
                                </div>
                            </div>

                            {{-- Upload dan Preview NIB (PDF) --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Nomor Induk Berusaha (NIB)</label>
                                <div class="col-lg-8 fv-row">

                                    {{-- Jika sudah ada file NIB tersimpan --}}
                                    @if (!empty($perusahaan->nib))
                                        <div class="mb-3">
                                            <a href="{{ asset( $perusahaan->nib_url) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-light-primary mb-3">
                                                <i class="ki-duotone ki-file fs-2 me-1"></i> Lihat / Download NIB
                                            </a>

                                            {{-- Preview file NIB lama --}}
                                            <iframe
                                                src="{{ asset( $perusahaan->nib_url) }}"
                                                width="100%"
                                                height="400px"
                                                style="border: 1px solid #ccc; border-radius: 6px;">
                                            </iframe>
                                        </div>
                                    @endif

                                    {{-- Input upload file baru --}}
                                    <input type="file"
                                           name="nib"
                                           accept="application/pdf"
                                           class="form-control form-control-lg form-control-solid" />
                                    <div class="form-text">Unggah file PDF (maksimal 2MB)</div>

                                    {{-- Tempat preview otomatis file baru --}}
                                    <div id="preview-nib" class="mt-3"></div>
                                </div>
                            </div>

                            {{-- Alamat --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Alamat</label>
                                <div class="col-lg-8 fv-row">
                                <textarea name="alamat" rows="3"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Alamat lengkap">{{ old('alamat', $perusahaan->alamat) }}</textarea>
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="row mb-6">
                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Deskripsi Perusahaan</label>
                                <div class="col-lg-8 fv-row">
                                <textarea name="deskripsi" rows="4"
                                class="form-control form-control-lg form-control-solid"
                                placeholder="Ceritakan tentang perusahaan Anda">{{ old('deskripsi', $perusahaan->deskripsi) }}</textarea>
                                </div>
                            </div>

                        </div>
                        <!--end::Card body-->

                        <!--begin::Actions-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="reset" class="btn btn-light btn-active-light-primary me-2">Batal</button>
                            <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">
                                Simpan Perubahan
                            </button>
                        </div>
                        <!--end::Actions-->

                    </form>
                    <!--end::Form-->
                </div>

                <!--end::Card body-->
            </div>
            <!--end::details View-->

        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@push('js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputNIB = document.querySelector('input[name="nib"]');
            const previewContainer = document.getElementById('preview-nib');

            inputNIB.addEventListener('change', function(event) {
                const file = event.target.files[0];
                previewContainer.innerHTML = ''; // kosongkan preview lama

                if (file && file.type === 'application/pdf') {
                    const fileURL = URL.createObjectURL(file);
                    previewContainer.innerHTML = `
                <iframe src="${fileURL}" width="100%" height="400px"
                    style="border: 1px solid #ccc; border-radius: 6px;"></iframe>
            `;
                } else if (file) {
                    previewContainer.innerHTML = `
                <p class="text-danger mt-2">File harus berupa PDF.</p>
            `;
                }
            });
        });
    </script>

@endpush

