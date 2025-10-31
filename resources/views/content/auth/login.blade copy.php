@extends('master')
@section('title','Sign In')
@section('login','active')
@push('css')
    <link href="{{asset('assets/plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
@endpush
@section('content_master')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Logo-->
            <a href="/" class="d-block d-lg-none mx-auto py-20">
                <img alt="Logo" src="assets/logo-bondowoso.png" class="theme-light-show h-25px" />
                <img alt="Logo" src="assets/logo-bondowoso.png" class="theme-dark-show h-25px" />
            </a>
            <!--end::Logo-->
            <!--begin::Aside-->
            <div class="d-flex flex-column flex-column-fluid flex-center w-lg-50 p-10">
                <!--begin::Wrapper-->
                <div class="d-flex justify-content-between flex-column-fluid flex-column w-100 mw-450px">
                    <!--begin::Header-->
                    <div class="d-flex flex-stack py-2">
                        <!--begin::Back link-->
                        <div class="me-2"></div>
                        <!--end::Back link-->
                        <!--begin::Sign Up link-->
                        <div class="m-0">
                            <a href="#" class="flex-center text-nowrap w-100">
                                <img alt="Logo" src="assets/logo-data-bantuan.png" class="h-100px me-3" /></a>
                        </div>
                        <!--end::Sign Up link=-->
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="py-20">
                        <!--begin::Form-->
                        <form class="form w-100" novalidate="novalidate" method="POST" id="kt_sign_in_form" data-kt-redirect-url="/" action="{{ route('login') }}">
                            @csrf
                            <!--begin::Body-->
                            <div class="card-body">
                                <!--begin::Heading-->
                                <div class="text-start mb-10">
                                    <!--begin::Title-->
                                    <h1 class="text-gray-900 mb-3 fs-3x" data-kt-translate="sign-in-title">Sign In</h1>
                                    <!--end::Title-->
                                    <!--begin::Text-->
                                    <div class="text-gray-500 fw-semibold fs-6" data-kt-translate="general-desc">Get access for create, update, and delete data</div>
                                    <!--end::Link-->
                                </div>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <!--begin::Heading-->
                                <!--begin::Input group=-->
                                <div class="fv-row mb-8">
                                    <!--begin::Email-->
                                    <input type="text" placeholder="Email" name="email" autocomplete="off" value="{{old('email')}}" class="form-control form-control-solid" />
                                    <!--end::Email-->
                                </div>
                                <!--end::Input group=-->
                                <div class="fv-row mb-7">
                                    <!--begin::Password-->
                                    <input type="password" placeholder="Password" name="password" autocomplete="off" data-kt-translate="sign-in-input-password" class="form-control form-control-solid" />
                                    <!--end::Password-->
                                </div>
                                <!--end::Input group=-->
                                <!--begin::Wrapper-->
                                <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-10">
                                    <div></div>
                                    <!--begin::Link-->
                                    <a href="https://wa.me/6282335596664" target="_blank" class="link-primary" data-kt-translate="sign-in-forgot-password">Forgot Password ?</a>
                                    <!--end::Link-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Actions-->
                                <div class="d-flex flex-stack">
                                    <!--begin::Submit-->
                                    <button id="kt_sign_in_submit" class="btn btn-primary me-2 flex-shrink-0">
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label" data-kt-translate="sign-in-submit">Sign In</span>
                                        <!--end::Indicator label-->
                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">
												<span data-kt-translate="general-progress">Please wait...</span>
												<span class="spinner-border spinner-border-sm align-middle ms-2"></span>
											</span>
                                        <!--end::Indicator progress-->
                                    </button>
                                    <!--end::Submit-->
                                    <!--begin::Social-->
                                    <div class="d-flex align-items-center">

                                        <!--end::Symbol-->
                                    </div>
                                    <!--end::Social-->
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--begin::Body-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Body-->
                    <!--begin::Footer-->
                    <div class="m-0">


                    </div>
                    <!--end::Footer-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Aside-->
            <!--begin::Body-->
            <div class="d-none d-lg-flex flex-lg-row-fluid w-50 bgi-size-cover bgi-position-y-center bgi-position-x-start bgi-no-repeat" style="background-image: url(assets/bg-login.png)"></div>
            <!--begin::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
@endsection

@push('js')
    <script>
        "use strict";

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
                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Check axios library docs: https://axios-http.com/docs/intro
                            axios.post(submitButton.closest('form').getAttribute('action'), new FormData(form)).then(function (response) {
                                if (response) {
                                    form.reset();

                                    // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
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
                                            form.querySelector('[name="email"]').value = "";
                                            form.querySelector('[name="password"]').value = "";

                                            //form.submit(); // submit form
                                            var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                            if (redirectUrl) {
                                                location.href = redirectUrl;
                                            }
                                        }
                                    });

                                    const redirectUrl = form.getAttribute('data-kt-redirect-url');

                                    // if (redirectUrl) {
                                    //     location.href = redirectUrl;
                                    // }
                                } else {
                                    // Show error popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                    Swal.fire({
                                        text: "Sorry, the email or password is incorrect, please try again.",
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            }).catch(function (error) {
                                Swal.fire({
                                    text: "Sorry, the email or password is incorrect, please try again.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }).then(() => {
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;
                            });
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
    <script src="assets/js/custom/authentication/sign-in/i18n.js"></script>
@endpush
