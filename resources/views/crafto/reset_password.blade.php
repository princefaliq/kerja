@extends('crafto.master')
@section('title', 'Reset Password')

@section('content')
    <section class="bg-dark-midnight-blue pt-10 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container">
            <div class="row g-0 justify-content-center">
                <div class="col-xl-6 bg-light p-6 box-shadow-extra-large border-radius-6px"
                     data-anime='{ "opacity": [0,1], "duration": 600 }'>

                    @if (session('status'))
                        <div class="alert alert-success box-shadow-extra-large bg-white alert-dismissable">
                            <a href="#" class="close" data-bs-dismiss="alert"><i class="fa-solid fa-xmark"></i></a>
                            <strong>Berhasil!</strong> {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger box-shadow-extra-large bg-white alert-dismissable">
                            <a href="#" class="close" data-bs-dismiss="alert"><i class="fa-solid fa-xmark"></i></a>
                            @foreach ($errors->all() as $error)
                                <strong>Kesalahan:</strong> {{ $error }}<br>
                            @endforeach
                        </div>
                    @endif

                    <span class="fs-26 xs-fs-24 alt-font fw-600 mb-20px d-block">
                    Atur Ulang Password
                </span>

                    <p class="mb-4">Masukkan password baru Anda di bawah ini.</p>

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <label class="mb-10px fw-500">Alamat Email <span class="text-red">*</span></label>
                        <input type="email" name="email" class="form-control bg-very-light-gray mb-20px"
                               value="{{ old('email', $email) }}" required readonly>

                        <label class="mb-10px fw-500">Password Baru <span class="text-red">*</span></label>
                        <input type="password" name="password" class="form-control bg-very-light-gray mb-20px" required>

                        <label class="mb-10px fw-500">Konfirmasi Password Baru <span class="text-red">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control bg-very-light-gray mb-20px" required>

                        <button class="btn btn-medium btn-round-edge btn-base-color btn-box-shadow w-100 text-transform-none" type="submit">
                            Simpan Password Baru
                        </button>

                        <a href="{{ route('login') }}" class="btn btn-medium btn-round-edge btn-yellow d-table btn-box-shadow d-lg-inline-block w-100 mt-2">
                            Kembali ke Login
                        </a>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
