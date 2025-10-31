@extends('crafto.master')
@section('title','Beranda')
@push('css')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css"
    />
@endpush
@section('content')
<section class="bg-dark-midnight-blue text-light pt-10">
    <div class="container">
        <div class="row g-0 justify-content-center">
            <div class="col-lg-6 col-md-10 bg-base-color p-6 box-shadow-extra-large border-radius-6px" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay":150, "staggervalue": 150, "easing": "easeOutQuad" }'>
                <span class="fs-26 xs-fs-24 alt-font fw-600 text-dark-gray mb-20px d-block">Create an account</span>
                <form action="{{ url('register/store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    {{-- Nama --}}
                    <label class="text-dark-gray mb-10px fw-500">Nama<span class="text-red">*</span></label>
                    <input class="mb-5px bg-very-light-gray form-control @error('name') is-invalid @enderror"
                           type="text" name="name" value="{{ old('name') }}" placeholder="Masukan nama sesuai KTP" />
                    @error('nama')
                    <small class="text-danger d-block mb-15px">{{ $message }}</small>
                    @enderror
                    {{-- No HP --}}
                    <label class="text-dark-gray mb-10px fw-500">No HP<span class="text-red">*</span></label>
                    <input class="mb-5px bg-very-light-gray form-control @error('no_hp') is-invalid @enderror"
                           type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukan no hp yang bisa dihubungi" />
                    @error('no_hp')
                    <small class="text-danger d-block mb-15px">{{ $message }}</small>
                    @enderror

                    {{-- Email --}}
                    <label class="text-dark-gray mb-10px fw-500">Email Address<span class="text-red">*</span></label>
                    <input class="mb-5px bg-very-light-gray form-control @error('email') is-invalid @enderror"
                           type="email" name="email" value="{{ old('email') }}" placeholder="Masukan email" />
                    @error('email')
                    <small class="text-danger d-block mb-15px">{{ $message }}</small>
                    @enderror

                    {{-- Password --}}
                    <label class="text-dark-gray mb-10px fw-500">Password<span class="text-red">*</span></label>
                    <input class="bg-very-light-gray form-control @error('password') is-invalid @enderror"
                           type="password" name="password" placeholder="Masukan password" />
                    <small class="text-warning mb-15px">Password harus minimal 8 karakter.</small>
                    @error('password')
                    <small class="text-danger d-block mb-15px">{{ $message }}</small>
                    @enderror

                    {{-- Catatan Privasi --}}
                    <span class="fs-13 lh-22 w-90 lg-w-100 md-w-90 sm-w-100 d-block mb-30px mt-5">
                        Kami akan menggunakan data pribadi Anda untuk membantu proses pendaftaran,
                        mempermudah akses ke akun Anda, dan keperluan lain sesuai dengan
                        <a href="#" class="text-dark-gray text-decoration-line-bottom fw-500">kebijakan privasi</a> kami.
                    </span>

                    <input type="hidden" name="redirect" value="">

                    <button class="btn btn-medium btn-round-edge btn-light btn-box-shadow w-100 text-transform-none"
                            type="submit">Register</button>

                    {{-- Optional: tampilkan error umum --}}
                    @if ($errors->any())
                        <div class="alert alert-danger mt-3">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </form>

            </div>
        </div>
    </div>
</section>

@endsection

