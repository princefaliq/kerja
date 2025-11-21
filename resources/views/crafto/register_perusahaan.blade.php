
@extends('crafto.master')
@section('title','Register Perusahaan')
@push('css')
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/cropperjs@1.6.2/dist/cropper.min.css"
    />
    <style>
        #finalPreview {
            border: 3px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            width: 150px;
            display: none;
            transition: .3s;
            object-fit: cover;
        }
        #finalPreview.active {
            display: block;
        }

        /* Modal cropper */
        #cropImage {
            width: 100%;
            max-height: 80vh;
            object-fit: contain;
        }

        .crop-area {
            background: #222;
            padding: 10px;
        }
    </style>

@endpush
@section('content')
    <section class="bg-dark-midnight-blue text-light pt-10">
        <div class="container">
            <div class="row g-0 justify-content-center">
                <div class="col-lg-7 col-md-10 bg-base-color p-6 box-shadow-extra-large border-radius-6px"
                     data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay":150 }'>

                <span class="fs-26 xs-fs-24 alt-font fw-600 text-dark-gray mb-20px d-block">
                    Daftar Akun Perusahaan
                </span>

                    <form action="{{ url('register-perusahaan/store') }}" id="regForm" enctype="multipart/form-data" method="post">
                        @csrf

                        {{-- Informasi User --}}
                        <div class="mb-20px">
                            <h6 class="fw-600 mb-10px text-dark-gray">Informasi Akun</h6>
                            <p class="text-muted fs-14 mb-15px">Data ini untuk membuat akun login perusahaan.</p>
                        </div>

                        {{-- Nama Perusahaan --}}
                        <label class="text-dark-gray mb-10px fw-500">Nama Perusahaan<span class="text-red">*</span></label>
                        <input class="mb-5px bg-very-light-gray form-control @error('name') is-invalid @enderror"
                               type="text" name="name" value="{{ old('name') }}" placeholder="Masukan nama perusahaan" />
                        @error('name') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror

                        {{-- Email --}}
                        <label class="text-dark-gray mb-10px fw-500">Email Perusahaan<span class="text-red">*</span></label>
                        <input class="mb-5px bg-very-light-gray form-control @error('email') is-invalid @enderror"
                               type="email" name="email" value="{{ old('email') }}" placeholder="Masukan email perusahaan" />
                        @error('email') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror

                        {{-- No HP --}}
                        <label class="text-dark-gray mb-10px fw-500">Nomor Telepon / WhatsApp<span class="text-red">*</span></label>
                        <input class="mb-5px bg-very-light-gray form-control @error('no_hp') is-invalid @enderror"
                               type="text" name="no_hp" value="{{ old('no_hp') }}" placeholder="Masukan nomor yang aktif" />
                        @error('no_hp') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror

                        {{-- Password --}}
                        <label class="text-dark-gray mb-10px fw-500">Password<span class="text-red">*</span></label>
                        <input class="bg-very-light-gray form-control @error('password') is-invalid @enderror"
                               type="password" name="password" placeholder="Password minimal 8 karakter" />
                        @error('password') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror


                        {{-- Informasi Perusahaan --}}
                        <div class="mt-30px mb-20px">
                            <h6 class="fw-600 mb-10px text-dark-gray">Detail Perusahaan</h6>
                            <p class="text-muted fs-14 mb-15px">Informasi ini digunakan untuk publikasi lowongan kerja.</p>
                        </div>
                        {{-- Logo Perusahaan --}}
                        <div class="text-center mb-5">
                            <label class="fw-bold">Upload Foto 3x4</label>
                            <input type="file" id="uploadFoto" accept="image/*" class="form-control">

                            <!-- PREVIEW HASIL CROP -->
                            <img id="finalPreview" class="mt-3 mx-auto" alt="Hasil Crop">

                            <input type="hidden" name="cropped_foto" id="cropped_foto">
                        </div>

                        {{-- Bidang Usaha --}}
                        <label class="text-dark-gray mb-10px fw-500">Bidang Usaha<span class="text-red">*</span></label>
                        <input class="mb-5px bg-very-light-gray form-control @error('bidang') is-invalid @enderror"
                               type="text" name="bidang" value="{{ old('bidang') }}" placeholder="Contoh: Teknologi Informasi, Retail, Makanan" />
                        @error('bidang') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror

                        {{-- NIB --}}
                        <label class="text-dark-gray mb-10px fw-500">
                            Upload NIB (Nomor Induk Berusaha)<span class="text-red">*</span>
                        </label>

                        <input
                            class="mb-5px bg-very-light-gray form-control @error('nib') is-invalid @enderror"
                            type="file" name="nib" accept="application/pdf"
                        />

                        {{-- Keterangan ukuran file --}}
                        <small class="text-muted d-block mb-10px">
                            File harus dalam format <strong>PDF</strong> dan ukuran maksimal <strong>2MB</strong>.
                        </small>

                        {{-- Validasi error --}}
                        @error('nib')
                        <small class="text-danger d-block mb-15px">{{ $message }}</small>
                        @enderror


                        {{-- Website --}}
                        <label class="text-dark-gray mb-10px fw-500">Website Perusahaan (Opsional)</label>
                        <input class="mb-5px bg-very-light-gray form-control @error('website') is-invalid @enderror"
                               type="text" name="website" value="{{ old('website') }}" placeholder="Masukan alamat website perusahaan" />
                        @error('website') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror

                        {{-- Alamat --}}
                        <label class="text-dark-gray mb-10px fw-500">Alamat Lengkap<span class="text-red">*</span></label>
                        <textarea class="bg-very-light-gray form-control @error('alamat') is-invalid @enderror"
                                  name="alamat" rows="3" placeholder="Masukan alamat lengkap perusahaan">{{ old('alamat') }}</textarea>
                        @error('alamat') <small class="text-danger d-block mb-15px">{{ $message }}</small> @enderror

                        {{-- Deskripsi --}}
                        <label class="text-dark-gray mb-10px fw-500">Deskripsi Perusahaan<span class="text-red">*</span></label>
                        <textarea class="bg-very-light-gray form-control @error('deskripsi') is-invalid @enderror"
                                  name="deskripsi" rows="3" placeholder="Ceritakan perusahaan Anda (bidang kerja, jumlah karyawan, dll)">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi') <small class="text-danger d-block mb-20px">{{ $message }}</small> @enderror


                        {{-- reCAPTCHA --}}
                        <input type="hidden" name="g-recaptcha-response" id="gRecaptcha">

                        <button
                            class="btn btn-medium btn-round-edge btn-light btn-box-shadow w-100 text-transform-none g-recaptcha mt-5"
                            data-sitekey="{{ env('INVISIBLE_RECAPTCHA_SITE_KEY') }}"
                            data-callback="onSubmit"
                            data-action="register"
                            type="button">
                            Daftar Perusahaan
                        </button>

                        {{-- Error Umum --}}
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
    <div class="modal fade" id="modalCrop" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Foto</h5>
                    <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body crop-area">
                    <img id="cropImage">
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="cropButton" class="btn btn-success">Crop & Simpan</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        function onSubmit(token) {
            document.getElementById('gRecaptcha').value = token;
            document.getElementById('regForm').submit();
        }
    </script>
    <script src="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.js"></script>

    <script>
        let cropper;

        const upload = document.getElementById('uploadFoto');
        const cropModal = new bootstrap.Modal(document.getElementById('modalCrop'));

        upload.addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function () {
                const img = document.getElementById('cropImage');
                img.src = reader.result;

                cropModal.show();

                // destroy previous cropper
                if (cropper) cropper.destroy();

                setTimeout(() => {
                    cropper = new Cropper(img, {
                        viewMode: 1,
                        autoCropArea: 1,
                        background: false,          // tidak pakai background cropper
                        dragMode: 'move',
                        movable: true,
                        zoomable: true,
                    });
                }, 200);
            };
            reader.readAsDataURL(file);
        });

        // tombol crop
        document.getElementById('cropButton').addEventListener('click', function () {
            if (!cropper) return;

            // ini penting untuk mempertahankan transparansi PNG
            const canvas = cropper.getCroppedCanvas({
                width: 300,
                height: 400,
                fillColor: 'rgba(0,0,0,0)',     // pastikan background = transparan
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high'
            });

            const finalPreview = document.getElementById('finalPreview');

            // HASIL PNG TRANSPARAN
            const base64png = canvas.toDataURL("image/png");

            // set preview
            finalPreview.src = base64png;
            finalPreview.classList.add("active");

            // simpan ke hidden input
            document.getElementById('cropped_foto').value = base64png;

            cropModal.hide();
        });
    </script>

@endpush
