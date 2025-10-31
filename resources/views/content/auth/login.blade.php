@extends('content.auth.master')
@section('title','Sign In')
@section('login','active')
@push('css')
    <link href="{{url('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .transparent-white {
            background-color: rgba(255, 255, 255, 0.8); /* 0.5 adalah tingkat transparansi */
        }
    </style>
@endpush
@section('content_master')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>body { background-image: url({{ url('logo/kerja.jpg') }});background-size: 100% 100%;} [data-bs-theme="dark"] body { background-image: url({{ url('logo/kerja.jpg') }});background-size: 100% auto;}</style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!--begin::Aside-->
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10">
                <!--begin::Aside-->
                <!--begin::Aside-->
            </div>
            <!--begin::Aside-->
            <!--begin::Body-->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <!--begin::Card-->
                <div class="transparent-white d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <!--begin::Wrapper-->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="/app/login" action="{{ url('login') }}">
                            @csrf
                            <!--begin::Heading-->
                            <!--begin::Heading-->
                            <div class="text-center mb-11">
                                <!--begin::Title-->
                                <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
                                <!--end::Title-->
                                <!--begin::Subtitle-->
                                <div class="text-dark fw-semibold fs-6">Kerja Berkah</div>
                                <!--end::Subtitle=-->
                            </div>
                            <!--begin::Heading-->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            <div class="row g-3 mb-9">
                                <!--begin::Col-->
                                <div class="col-md-12">
                                    <!--begin::Google link=-->
                                        <img alt="Logo" src="{{url('logo/logo_kerja_berkah.png')}}" class="h-15px me-3" />
                                    <!--end::Google link=-->
                                </div>
                                <!--end::Col-->
                                <!--begin::Col-->
                               {{-- <div class="col-md-6">
                                    <!--begin::Google link=-->
                                    <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                        <img alt="Logo" src="assets/media/svg/brand-logos/apple-black.svg" class="theme-light-show h-15px me-3" />
                                        <img alt="Logo" src="assets/media/svg/brand-logos/apple-black-dark.svg" class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
                                    <!--end::Google link=-->
                                </div>--}}
                                <!--end::Col-->
                            </div>
                            <!--end::Login options-->
                            <!--begin::Separator-->
                            <div class="separator separator-content my-14">
                                <span class="w-125px text-dark fw-semibold fs-7">Email Or no HP</span>
                            </div>
                            <!--end::Separator-->
                            <!--begin::Input group=-->
                            <div class="fv-row mb-8">
                                <!--begin::Email-->
                                <input type="text" placeholder="Email/HP" name="login" id="login" autocomplete="off" class="form-control border-dark text-dark bg-transparent" />
                                <!--end::Email-->
                            </div>
                            <!--end::Input group=-->
                            <div class="fv-row mb-3">
                                <!--begin::Password-->
                                <input type="password" placeholder="Password" name="password" id="password" autocomplete="off" class="form-control border-dark text-dark bg-transparent" />
                                <!--end::Password-->
                            </div>
                            <!--end::Input group=-->
                            <!--begin::Submit button-->
                            <div class="d-grid mb-10">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Sign In</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Submit button-->
                            <div class="text-gray-500 text-center fw-semibold fs-6">Belum jadi member?
                                <a href="{{ url('/') }}" class="link-primary">Sign up</a></div>
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Wrapper-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>

    <!-- -------------- -->
@endsection

@push('js')
    <script>
        "use strict";
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        })
        // Class definition
        var KTSigninGeneral = function () {
            // Elements
            var form;
            var submitButton;
            var validator;

            // Handle form
            var handleValidation = function (e) {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'email': {
                                validators: {
                                    regexp: {
                                        regexp: /^[^\s@]+@[^\s@]+(\.[^\s@]+)?$/,
                                        message: 'The value is not a valid email address',
                                    },
                                    notEmpty: {
                                        message: 'Email address is required'
                                    }
                                }
                            },
                            'password': {
                                validators: {
                                    notEmpty: {
                                        message: 'The password is required'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger(),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',  // comment to enable invalid state icons
                                eleValidClass: '' // comment to enable valid state icons
                            })
                        }
                    }
                );
            }



            var handleSubmitAjax = function (e) {
                // Handle form submit
                submitButton.addEventListener('click', function (e) {
                    // Prevent button default action
                    e.preventDefault();
                    //console.log('testing')
                    // Validate form
                    validator.validate().then(function (status) {
                        if (status === 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            // Ambil data dari input
                            var login = $('#login').val();
                            var password = $('#password').val();
                            var data = {
                                login: login,
                                password: password
                            };
                            // Disable button to avoid multiple click
                            submitButton.disabled = true;
                            $.ajax({
                                url: '{{ route("login") }}',
                                type: 'POST',
                                data: data,
                                success: function(response) {
                                    console.log(response)
                                    localStorage.setItem('token', response.token);
                                    Swal.fire({
                                        text: "You have successfully logged in!",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        if (result.isConfirmed) {
                                            form.querySelector('[name="login"]').value = "";
                                            form.querySelector('[name="password"]').value = "";
                                            if (response.redirect) {
                                                location.href = response.redirect;
                                            } else {
                                                location.href = '/';
                                            }
                                            //form.submit(); // submit form
                                            /*var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                            if (redirectUrl) {
                                                location.href = redirectUrl;
                                            }*/
                                        }
                                    });


                                },
                                error: function(xhr) {
                                    // Mengambil respons JSON
                                    var response = xhr.responseJSON;

                                    // Menyusun pesan kesalahan
                                    var errorMessages = Object.values(response.errors).flat().join('<br>');
                                    var generalMessage = response.message;

                                    // Menggabungkan pesan umum dan kesalahan spesifik
                                    var fullMessage = generalMessage + '<br>' + errorMessages;

                                    Swal.fire({
                                        html: fullMessage,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    }).then(function (result) {
                                        if (result.isConfirmed) {
                                            form.querySelector('[name="login"]').value = "";
                                            form.querySelector('[name="password"]').value = "";

                                            //form.submit(); // submit form
                                            var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                            if (redirectUrl) {
                                                location.href = redirectUrl;
                                            }
                                        }
                                    });

                                }
                            }).then(()=>{
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                            });
                            // Check axios library docs: https://axios-http.com/docs/intro

                        } else {
                            // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                            Swal.fire({
                                text: "Sorry, looks like there are some errors detected, please try again.",
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "Ok, got it!",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                });
            }

            var isValidUrl = function(url) {
                try {
                    new URL(url);
                    return true;
                } catch (e) {
                    return false;
                }
            }

            // Public functions
            return {
                // Initialization
                init: function () {
                    form = document.querySelector('#kt_sign_in_form');
                    submitButton = document.querySelector('#kt_sign_in_submit');

                    handleValidation();

                    if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                        handleSubmitAjax(); // use for ajax submit
                    } else {
                        handleSubmitDemo(); // used for demo purposes only
                    }
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTSigninGeneral.init();
        });

    </script>
{{--    <script src="assets/js/custom/authentication/sign-in/general.js"></script>--}}
    <script src="{{ url('assets/js/custom/authentication/sign-in/i18n.js') }}"></script>
@endpush
