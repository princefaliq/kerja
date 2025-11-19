@extends('crafto.master')
@section('title','Beranda')
@push('css')
    <style>
        .check-box {
            appearance: none;
            -webkit-appearance: none;
            background-color: transparent;
            border: 2px solid white;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            cursor: pointer;
            position: relative;
        }

        .check-box:checked::after {
            content: '';
            position: absolute;
            top: 1px;
            left: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            transform: rotate(45deg);
        }
    </style>
@endpush
@section('content')
    <section class="bg-dark-midnight-blue pt-10 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container">
            <div class="row g-0 justify-content-center ">
                <div class="col-xl-6 bg-light p-6 box-shadow-extra-large border-radius-6px" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay":100, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    @if (session('success'))
                        <div class="alert alert-success box-shadow-extra-large bg-white alert-dismissable">
                            <a href="#" class="close" data-bs-dismiss="alert" aria-label="close"><i class="fa-solid fa-xmark"></i></a>
                            <strong>Success!</strong> {{ session('success') }}.
                        </div>
                    @endif
                        @if ($errors->any())
                            <div class="alert alert-danger box-shadow-extra-large bg-white alert-dismissable">
                                <a href="#" class="close" data-bs-dismiss="alert" aria-label="close"><i class="fa-solid fa-xmark"></i></a>
                                    @foreach ($errors->all() as $error)
                                    <strong>Terjadi kesalahan!</strong> {{ $error }}
                                    @endforeach
                            </div>
                        @endif
                    <span class="fs-26 xs-fs-24 alt-font fw-600 mb-20px d-block">Member login</span>
                    <form action="{{ route('login') }}" id="frmLogin" method="post">
                        @csrf
                        <label class="mb-10px fw-500">No HP / email <span class="text-red">*</span></label>
                        <input class="mb-20px bg-very-light-gray form-control " type="text" name="login" placeholder="Enter your username" />
                        <label class="mb-10px fw-500">Password<span class="text-red">*</span></label>
                        <div class="position-relative mb-20px">
                            <input id="password"
                                   class="bg-very-light-gray form-control "
                                   type="password" name="password" placeholder="Enter your password" />
                            <span id="togglePassword"
                                  class="position-absolute top-50 end-0 translate-middle-y me-3"
                                  style="cursor: pointer;">
                                <i class="fa fa-eye" id="eyeIcon"></i>
                            </span>
                        </div>
                        <div class="position-relative terms-condition-box text-start d-flex align-items-center mb-20px">
                            <label>
                                <input type="checkbox" name="remember" id="remember" value="1" class="terms-condition check-box align-middle">
                                <span class="box fs-14">Remember me</span>
                            </label>
                            <a
                                href="{{ route('password.request') }}"
                                class="fs-14 fw-500 text-decoration-line-bottom ms-auto"
                            >
                                Lupa Password?
                            </a>
                        </div>
                        <input type="hidden" name="redirect" value="">
{{--                        <button class="btn btn-medium btn-round-edge btn-base-color btn-box-shadow w-100 mb-10px text-transform-none " type="submit">LOGIN</button>--}}
                        <button
                            class="g-recaptcha btn btn-medium btn-round-edge btn-base-color btn-box-shadow w-100 mb-10px text-transform-none"
                            data-sitekey="{{ env('INVISIBLE_RECAPTCHA_SITE_KEY') }}"
                            data-callback="onSubmit"
                            data-action="submit">
                            LOGIN
                        </button>
                        <a href="{{ url('register') }}" class="btn btn-medium btn-round-edge btn-yellow d-table btn-box-shadow d-lg-inline-block w-100">Register</a>
                        <div class="form-results mt-20px d-none"></div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <script>
        function onSubmit(token) {
            document.getElementById("frmLogin").submit();
        }
        document.getElementById('togglePassword').addEventListener('click', function () {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
@endpush
