@extends('crafto.master')
@section('title','Lupa Password')

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
                <div class="col-xl-6 bg-light p-6 box-shadow-extra-large border-radius-6px"
                     data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay":100, "staggervalue": 150, "easing": "easeOutQuad" }'>

                    {{-- Alert sukses --}}
                    @if (session('status'))
                        <div class="alert alert-success box-shadow-extra-large bg-white alert-dismissable">
                            <a href="#" class="close" data-bs-dismiss="alert" aria-label="close">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            <strong>Berhasil!</strong> {{ session('status') }}
                        </div>
                    @endif

                    {{-- Alert error --}}
                    @if ($errors->any())
                        <div class="alert alert-danger box-shadow-extra-large bg-white alert-dismissable">
                            <a href="#" class="close" data-bs-dismiss="alert" aria-label="close">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                            @foreach ($errors->all() as $error)
                                <strong>Terjadi kesalahan!</strong> {{ $error }}
                            @endforeach
                        </div>
                    @endif

                    <span class="fs-26 xs-fs-24 alt-font fw-600 mb-20px d-block">
                    Lupa Password
                </span>

                    <p class="mb-4">
                        Masukkan alamat email yang terdaftar. Kami akan mengirimkan link untuk mengatur ulang password Anda.
                    </p>

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <label class="mb-10px fw-500">Alamat Email <span class="text-red">*</span></label>
                        <input
                            class="mb-20px bg-very-light-gray form-control"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="Masukkan email anda"
                        />

                        <button
                            class="btn btn-medium btn-round-edge btn-base-color btn-box-shadow w-100 mb-10px text-transform-none text-uppercase"
                            type="submit">
                            KIRIM LINK RESET PASSWORD
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-medium btn-round-edge btn-yellow d-table btn-box-shadow d-lg-inline-block w-100">
                            Kembali ke Login
                        </a>
                    </form>

                </div>
            </div>
        </div>
    </section>
@endsection

