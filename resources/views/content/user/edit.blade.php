@extends('content.page')
@section('title','Edit User')
@section('user','show')
@section('bread')
    <li class="breadcrumb-item">
        <span class="bullet bg-gray-500 w-5px h-2px"></span>
    </li>
    <!--end::Item-->
    <li class="breadcrumb-item text-muted">User</li>
    @php
        $url=$_SERVER['REQUEST_URI'];
        $part=explode('/',trim($url,'/'));
    @endphp
    @if(end($part) != '')
        <!--begin::Item-->
        <li class="breadcrumb-item">
            <span class="bullet bg-gray-500 w-5px h-2px"></span>
        </li>
        <!--end::Item-->
        <li class="breadcrumb-item text-muted">{{ ucfirst(end($part)) }}</li>
        <!--end::Item-->
    @endif
@endsection
@push('css')

@endpush
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">

                            <h1 class="anchor fw-bold mb-5" data-kt-scroll-offset="50">
                                <a href="#@yield('title')"></a>
                                @yield('title')</h1>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--begin::Card title-->

                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form id="kt_modal_add_user_form" enctype="multipart/form-data" class="form" action="{{ url('user/update/'.$id) }}" method="post">
                        @csrf
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-10" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="d-block fw-semibold fs-6 mb-5">Avatar</label>
                                <!--end::Label-->
                                <!--begin::Image placeholder-->
                                <style>.image-input-placeholder { background-image: url('{{ url('assets/media/svg/files/blank-image.svg') }}'); } [data-bs-theme="dark"] .image-input-placeholder { background-image: url('{{ url('assets/media/svg/files/blank-image.svg') }}'); }</style>
                                <!--end::Image placeholder-->
                                <!--begin::Image input-->
                                <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                    <!--begin::Preview existing avatar-->
                                    <div class="image-input-wrapper w-125px h-125px" style="background-image: url({{ url($user->avatar) }});"></div>
                                    <!--end::Preview existing avatar-->
                                    <!--begin::Label-->
                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                        <i class="ki-duotone ki-pencil fs-7">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                        </i>
                                        <!--begin::Inputs-->
                                        <input type="file" value="{{ url($user->avatar) }}" name="avatar" accept=".png, .jpg, .jpeg" />
                                        <input type="hidden" name="avatar_remove" />
                                        <!--end::Inputs-->
                                    </label>
                                    <!--end::Label-->
                                    <!--begin::Cancel-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
																					<i class="ki-duotone ki-cross fs-2">
																						<span class="path1"></span>
																						<span class="path2"></span>
																					</i>
																				</span>
                                    <!--end::Cancel-->
                                    <!--begin::Remove-->
                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
																					<i class="ki-duotone ki-cross fs-2">
																						<span class="path1"></span>
																						<span class="path2"></span>
																					</i>
																				</span>
                                    <!--end::Remove-->
                                </div>
                                <!--end::Image input-->
                                <!--begin::Hint-->
                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                <!--end::Hint-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Full Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Full name" value="{{ $user->name }}" />
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="email" name="email" readonly class="form-control form-control-solid mb-3 mb-lg-0" placeholder="example@domain.com" value="{{ $user->email }}" />
                                <!--end::Input-->
                            </div>
                            <div class="fv-row mb-7" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <label class="fw-semibold fs-6 mb-2">Password</label>
                                        <input class="form-control form-control-solid" type="password" placeholder="Password" name="password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
												<i class="ki-duotone ki-eye-slash fs-2"></i>
												<i class="ki-duotone ki-eye fs-2 d-none"></i>
											</span>
                                    </div>
                                    <!--end::Input wrapper-->
                                    <!--begin::Meter-->
                                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                    </div>
                                    <!--end::Meter-->
                                </div>
                                <!--end::Wrapper-->
                                <!--begin::Hint-->
                                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
                                <!--end::Hint-->
                            </div>
                            <div class="fv-row mb-7">
                                <label class="fw-semibold fs-6 mb-2">Repeat Password</label>
                                <!--begin::Repeat Password-->
                                <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control form-control-solid" />
                                <!--end::Repeat Password-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-5">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-5">Role</label>
                                <!--end::Label-->
                                <!--begin::Roles-->
                                <!--begin::Input row-->
                                <div class="row">
                                    @foreach($role as $index => $item)
                                        <div class="d-flex col-4">
                                            <!--begin::Radio-->
                                            <div class="form-check form-check-custom form-check-solid">
                                                <!--begin::Input-->
                                                <input class="form-check-input me-3" name="role[]" type="checkbox" value="{{ $item->name }}" @if(in_array($item->name, $user->roles->pluck('name')->toArray())) checked @endif/>
                                                <!--end::Input-->
                                                <!--begin::Label-->
                                                <label class="form-check-label" for="kt_modal_update_role_option_0">
                                                    <div class="fw-bold text-gray-800">{{ $item->name }}</div>
                                                </label>
                                                <!--end::Label-->
                                            </div>
                                            <!--end::Radio-->
                                        </div>

                                        @if (($index + 1) % 3 == 0 && $index + 1 < count($role))
                                            <div class="col-12">
                                                <div class='separator separator-dashed my-5'></div>
                                            </div>

                                        @endif
                                    @endforeach

                                </div>

                                <!--end::Input row-->
                                <div class='separator separator-dashed my-5'></div>
                                <!--begin::Input row-->

                                <!--end::Input row-->
                                <!--end::Roles-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <a href="{{ url('user') }}" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</a>
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
																			<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>


@endsection

@push('js')
    <script>
        "use strict";

        // Class definition
        var KTSignupGeneral = function () {
            // Elements
            var form;
            var submitButton;
            var validator;
            var passwordMeter;

            // Handle form
            var handleForm = function (e) {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {

                            'email': {
                                validators: {
                                    regexp: {
                                        regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
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
                                    },
                                    callback: {
                                        message: 'Please enter valid password',
                                        callback: function (input) {
                                            if (input.value.length > 0) {
                                                return validatePassword();
                                            }
                                        }
                                    }
                                }
                            },
                            'confirm-password': {
                                validators: {
                                    notEmpty: {
                                        message: 'The password confirmation is required'
                                    },
                                    identical: {
                                        compare: function () {
                                            return form.querySelector('[name="password"]').value;
                                        },
                                        message: 'The password and its confirm are not the same'
                                    }
                                }
                            },

                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger({
                                event: {
                                    password: false
                                }
                            }),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',  // comment to enable invalid state icons
                                eleValidClass: '' // comment to enable valid state icons
                            })
                        }
                    }
                );

                // Handle form submit
                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    validator.revalidateField('password');

                    validator.validate().then(function (status) {
                        if (status == 'Valid') {
                            // Show loading indication
                            submitButton.setAttribute('data-kt-indicator', 'on');

                            // Disable button to avoid multiple click
                            submitButton.disabled = true;

                            // Simulate ajax request
                            setTimeout(function () {
                                // Hide loading indication
                                submitButton.removeAttribute('data-kt-indicator');

                                // Enable button
                                submitButton.disabled = false;

                                // Show message popup. For more info check the plugin's official documentation: https://sweetalert2.github.io/
                                Swal.fire({
                                    text: "You have successfully reset your password!",
                                    icon: "success",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                }).then(function (result) {
                                    if (result.isConfirmed) {
                                        form.reset();  // reset form
                                        passwordMeter.reset();  // reset password meter
                                        //form.submit();

                                        //form.submit(); // submit form
                                        var redirectUrl = form.getAttribute('data-kt-redirect-url');
                                        if (redirectUrl) {
                                            location.href = redirectUrl;
                                        }
                                    }
                                });
                            }, 1500);
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

                // Handle password input
                form.querySelector('input[name="password"]').addEventListener('input', function () {
                    if (this.value.length > 0) {
                        validator.updateFieldStatus('password', 'NotValidated');
                    }
                });
            }


            // Handle form ajax
            var handleFormAjax = function (e) {
                // Init form validation rules. For more info check the FormValidation plugin's official documentation:https://formvalidation.io/
                validator = FormValidation.formValidation(
                    form,
                    {
                        fields: {
                            'name': {
                                validators: {
                                    notEmpty: {
                                        message: 'Name is required'
                                    }
                                }
                            },
                            'email': {
                                validators: {
                                    regexp: {
                                        regexp: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
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
                                    },
                                    callback: {
                                        message: 'Please enter valid password',
                                        callback: function (input) {
                                            if (input.value.length > 0) {
                                                return validatePassword();
                                            }
                                        }
                                    }
                                }
                            },
                            'password_confirmation': {
                                validators: {
                                    notEmpty: {
                                        message: 'The password confirmation is required'
                                    },
                                    identical: {
                                        compare: function () {
                                            return form.querySelector('[name="password"]').value;
                                        },
                                        message: 'The password and its confirm are not the same'
                                    }
                                }
                            },
                            'toc': {
                                validators: {
                                    notEmpty: {
                                        message: 'You must accept the terms and conditions'
                                    }
                                }
                            }
                        },
                        plugins: {
                            trigger: new FormValidation.plugins.Trigger({
                                event: {
                                    password: false
                                }
                            }),
                            bootstrap: new FormValidation.plugins.Bootstrap5({
                                rowSelector: '.fv-row',
                                eleInvalidClass: '',  // comment to enable invalid state icons
                                eleValidClass: '' // comment to enable valid state icons
                            })
                        }
                    }
                );

                // Handle form submit
                submitButton.addEventListener('click', function (e) {
                    e.preventDefault();

                    validator.revalidateField('password');

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

                                    const redirectUrl = form.getAttribute('data-kt-redirect-url');

                                    if (redirectUrl) {
                                        location.href = redirectUrl;
                                    }
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
                            }).catch(function (error) {
                                Swal.fire({
                                    text: "Sorry, looks like there are some errors detected, please try again.",
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

                // Handle password input
                form.querySelector('input[name="password"]').addEventListener('input', function () {
                    if (this.value.length > 0) {
                        validator.updateFieldStatus('password', 'NotValidated');
                    }
                });
            }


            // Password input validation
            var validatePassword = function () {
                return (passwordMeter.getScore() > 50);
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
                    // Elements
                    form = document.querySelector('#kt_sign_up_form');
                    submitButton = document.querySelector('#kt_sign_up_submit');
                    // passwordMeter = KTPasswordMeter.getInstance(form.querySelector('[data-kt-password-meter="true"]'));

                    // if (isValidUrl(submitButton.closest('form').getAttribute('action'))) {
                    //     handleFormAjax();
                    // } else {
                    //     handleForm();
                    // }
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function () {
            KTSignupGeneral.init();
        });
    </script>

@endpush
