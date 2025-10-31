@extends('crafto.master')
@section('title','Create Profile')
@push('css')
    <link href="https://unpkg.com/cropperjs@1.5.13/dist/cropper.min.css" rel="stylesheet"/>
    <style>
        /* ============================= */
        /* CARD TAMBAHAN */
        /* ============================= */
        .card-custom {
            min-height: 400px;
            max-height: 400px;
            overflow-y: auto;
        }

        /* ============================= */
        /* HASIL CROP FOTO */
        /* ============================= */
        #hasilCrop {
            border: 3px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
            margin-top: 10px;
            max-width: 150px;
            opacity: 0;
            transform: scale(0.95);
            transition: opacity 0.5s ease, transform 0.3s ease;
            display: none;
        }

        /* Saat hasilCrop aktif (sudah diisi src) */
        #hasilCrop.active {
            display: block;
            opacity: 1;
            transform: scale(1);
        }

        #hasilCrop:hover {
            transform: scale(1.05);
        }
        .imageAvatar:hover {
            transform: scale(1.05);
        }
        /* ============================= */
        /* MODAL CROPPER */
        /* ============================= */
        .crop-container {
            width: 100%;
            max-height: 80vh;
            overflow: hidden;
            background-color: #222;
        }

        #previewFoto {
            width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
@endpush
@section('content')
    <section class="bg-dark-midnight-blue text-light pt-8 ps-6 pe-6 lg-ps-2 lg-pe-2 sm-ps-0 sm-pe-0">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-12 breadcrumb breadcrumb-style-01 fs-14">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="{{ url('/profile') }}">Profile</a></li>
                        <li>Isi Profile</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="position-relative">
            <div class="container" data-anime='{ "el": "childs", "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>

                @if ($errors->any())
                    <div class="alert alert-danger box-shadow-extra-large bg-white alert-dismissable">
                        <a href="#" class="close" data-bs-dismiss="alert" aria-label="close"><i class="fa-solid fa-xmark"></i></a>
                        <strong>Terjadi kesalahan!</strong> Silakan periksa kembali data berikut:
                        <ul class="mt-2 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col text-center">
                        <h2 class="fw-700 alt-font text-dark-gray ls-minus-2px">Isi Biodata</h2>
                    </div>
                </div>
                <div class="row align-items-center justify-content-center position-relative z-index-1">
                    <div class="col-xl-10 col-lg-12">
                        <!-- start contact form -->
                        <form action="{{ route('profile.store') }}" method="POST" enctype="multipart/form-data" class="row contact-form-style-02">
                            @csrf
                            {{-- NIK --}}
                            <div class="col-md-12 mb-3">
                                <label class="text-dark mb-10px fw-500">NIK<span class="text-red">*</span></label>
                                <input class="border-radius-4px form-control @error('nik') is-invalid @enderror"
                                       maxlength="16" type="text" name="nik" value="{{ old('nik') }}" placeholder="Masukan NIK" required>
                                @error('nik')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Tanggal Lahir<span class="text-red">*</span></label>
                                <input class="border-radius-4px form-control @error('tgl_lahir') is-invalid @enderror"
                                       type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required>
                                @error('tgl_lahir')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Jenis Kelamin <span class="text-red">*</span></label>
                                <select name="jenis_kelamin" class="border-radius-4px form-control @error('jenis_kelamin') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki" {{ old('jenis_kelamin') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="perempuan" {{ old('jenis_kelamin') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('jenis_kelamin')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Status Pernikahan --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Status Pernikahan <span class="text-red">*</span></label>
                                <select name="status_pernikahan" class="border-radius-4px form-control @error('status_pernikahan') is-invalid @enderror" required>
                                    <option value="">Pilih Status</option>
                                    <option value="Belum Kawin" {{ old('status_pernikahan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_pernikahan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                </select>
                                @error('status_pernikahan')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Disabilitas --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Apakah Anda Disabilitas? <span class="text-red">*</span></label>
                                <select name="disabilitas" class="border-radius-4px form-control @error('disabilitas') is-invalid @enderror" required>
                                    <option value="">Pilih Jawaban</option>
                                    <option value="iya" {{ old('disabilitas') == 'iya' ? 'selected' : '' }}>Iya</option>
                                    <option value="tidak" {{ old('disabilitas') == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                </select>
                                @error('disabilitas')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Provinsi --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Provinsi <span class="text-red">*</span></label>
                                <select id="provinsi" name="provinsi" class="border-radius-4px form-control @error('provinsi') is-invalid @enderror" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                @error('provinsi')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Kabupaten --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Kabupaten/Kota <span class="text-red">*</span></label>
                                <select id="kabupaten" name="kabupaten" class="border-radius-4px form-control @error('kabupaten') is-invalid @enderror" required>
                                    <option value="">Pilih Kabupaten/Kota</option>
                                </select>
                                @error('kabupaten')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Kecamatan --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Kecamatan <span class="text-red">*</span></label>
                                <select id="kecamatan" name="kecamatan" class="border-radius-4px form-control @error('kecamatan') is-invalid @enderror" required>
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                @error('kecamatan')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Desa --}}
                            <div class="col-md-6 mb-3">
                                <label class="text-dark mb-10px fw-500">Desa/Kelurahan <span class="text-red">*</span></label>
                                <select id="desa" name="desa" class="border-radius-4px form-control @error('desa') is-invalid @enderror" required>
                                    <option value="">Pilih Desa/Kelurahan</option>
                                </select>
                                @error('desa')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>

                            {{-- Alamat --}}
                            <div class="col-md-12 mb-3">
                                <label class="text-dark mb-10px fw-500">Alamat<span class="text-red">*</span></label>
                                <textarea class="border-radius-4px form-control @error('alamat') is-invalid @enderror"
                                          name="alamat" placeholder="Masukan alamat sesuai KTP" required>{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <small class="text-danger d-block mb-15px">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="row">
                                {{-- ============================= --}}
                                {{-- Upload Dokumen Lamaran --}}
                                {{-- ============================= --}}
                                <div class="col-12 mb-4">
                                    <h5 class="fw-700 text-dark mb-3 border-bottom pb-2">
                                        <i class="bi bi-file-earmark-arrow-up me-2 text-golden-yellow"></i>
                                        Upload Dokumen Lamaran
                                    </h5>
                                </div>

                                @foreach ([
                                    'ktp' => 'KTP',
                                    'cv' => 'Curriculum Vitae (CV)',
                                    'ijazah' => 'Ijazah Terakhir',
                                    'ak1' => 'Kartu Pencari Kerja (AK1)',
                                ] as $name => $label)
                                    <div class="col-md-6 mb-4">
                                        <div class="card border-0 shadow-sm p-3 h-100">
                                            <label class="fw-600 text-dark mb-2">
                                                <i class="bi bi-file-earmark-pdf text-danger me-2"></i>{{ $label }}
                                                <span class="text-red">*</span>
                                            </label>
                                            <input type="file" name="{{ $name }}" accept=".pdf"
                                                   class="form-control @error($name) is-invalid @enderror"
                                                   onchange="previewFileName(this, '{{ $name }}')" required>
                                            <small id="preview-{{ $name }}" class="text-muted d-block mt-1">Belum ada file</small>
                                            @error($name)
                                            <small class="text-danger d-block">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach

                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm p-3 h-100">
                                        <label class="fw-600 text-dark mb-2">
                                            <i class="bi bi-award text-info me-2"></i>
                                            Sertifikat / Pengalaman Kerja (Opsional)
                                        </label>
                                        <input type="file" name="sertifikat" accept=".pdf"
                                               class="form-control @error('sertifikat') is-invalid @enderror"
                                               onchange="previewFileName(this, 'sertifikat')">
                                        <small id="preview-sertifikat" class="text-muted d-block mt-1">Belum ada file</small>
                                        @error('sertifikat')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card border-0 shadow-sm p-3 h-100">
                                        <label class="fw-600 text-dark mb-2">
                                            <i class="bi bi-paperclip text-secondary me-2"></i>
                                            Syarat Lain (Opsional)
                                        </label>
                                        <input type="file" name="syarat_lain" accept=".pdf"
                                               class="form-control @error('syarat_lain') is-invalid @enderror"
                                               onchange="previewFileName(this, 'syarat_lain')">
                                        <small id="preview-syarat_lain" class="text-muted d-block mt-1">Belum ada file</small>
                                        @error('syarat_lain')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                {{-- ============================= --}}
                                {{-- Upload Foto 3x4 --}}
                                {{-- ============================= --}}
                                <div class="col-12 mt-3">
                                    <h5 class="fw-700 text-dark mb-3 border-bottom pb-2">
                                        <i class="bi bi-person-bounding-box me-2 text-golden-yellow"></i>
                                        Upload Pass Foto 3x4
                                    </h5>
                                </div>

                                <div class="col-md-12 mb-4">
                                    <div class="card border-0 shadow-sm p-3 h-100 text-center">
                                        <label class="fw-600 text-dark mb-2 d-block">Upload Foto (JPG/PNG)</label>
                                        <input type="file" id="pass_foto" name="pass_foto" accept="image/*"
                                               class="form-control @error('pass_foto') is-invalid @enderror">
                                        <small class="text-muted d-block mt-1">Ukuran disarankan 3x4, maksimal 2MB</small>
                                        @error('pass_foto')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                        <div class="d-flex justify-content-center mt-3">
                                            <img id="hasilCrop" class="border rounded shadow-sm d-none text-center" style="width: 150px; object-fit: cover;" alt="Preview Foto">
                                        </div>
                                        <input type="hidden" name="cropped_pass_foto" id="cropped_pass_foto">
                                    </div>
                                </div>
                            </div>


                            <!-- Submit -->
                            <div class="col-xl-6 col-md-7">
                                <p class="mb-0 fs-14 lh-26 text-center text-md-start w-90 md-w-100">
                                    Kami berkomitmen menjaga privasi Anda. File hanya digunakan untuk keperluan rekrutmen.
                                </p>
                            </div>
                            <div class="col-xl-6 col-md-5 text-center text-md-end sm-mt-20px">
                                <button class="btn btn-base-color btn-switch-text btn-large left-icon btn-round-edge text-transform-none" type="submit">
                        <span>
                            <span><i class="bi bi-upload"></i></span>
                            <span class="btn-double-text" data-text="Kirim Lamaran">Kirim Lamaran</span>
                        </span>
                                </button>
                            </div>
                        </form>
                        <!-- end contact form -->
                    </div>
                </div>
            </div>
        </section>

    <!-- ============================= -->
    <!-- MODAL CROPPER FULLSCREEN -->
    <!-- ============================= -->
    <!-- Modal Crop -->
    <div class="modal fade" id="cropModal" tabindex="-1" aria-labelledby="cropModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- modal lebih lebar -->
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">Crop Foto 3x4</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0" style="background-color: #222;">
                    <div class="crop-container" style="width: 100%; max-height: 80vh; overflow: hidden;">
                        <img id="previewFoto" style="width: 100%; height: auto; display: block; margin: 0 auto;" />
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" id="btnCrop" class="btn btn-success">Crop & Simpan</button>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <!-- ============================= -->
    <!-- SCRIPTS -->
    <!-- ============================= -->
    <!-- CropperJS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let cropper;
            const input = document.getElementById('pass_foto');
            const preview = document.getElementById('previewFoto');
            const hasil = document.getElementById('hasilCrop');
            const hiddenInput = document.getElementById('cropped_pass_foto');
            const cropModal = new bootstrap.Modal(document.getElementById('cropModal'));

            input.addEventListener('change', (event) => {
                const file = event.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = () => {
                    preview.src = reader.result;
                    cropModal.show();

                    if (cropper) cropper.destroy();

                    setTimeout(() => {
                        cropper = new Cropper(preview, {
                            aspectRatio: 3 / 4,
                            viewMode: 1,
                            autoCropArea: 1,
                            responsive: true,
                            background: false,
                            movable: true,
                            zoomable: true,
                            dragMode: 'move',
                        });
                    }, 300);
                };
                reader.readAsDataURL(file);
            });

            document.getElementById('btnCrop').addEventListener('click', () => {
                if (cropper) {
                    const canvas = cropper.getCroppedCanvas({
                        width: 300,
                        height: 400,
                    });

                    // tampilkan hasil crop di preview
                    hasil.src = canvas.toDataURL('image/jpeg');
                    hasil.classList.add('active');
                    hasil.classList.remove('d-none');

                    // simpan hasil crop ke input hidden (base64)
                    hiddenInput.value = canvas.toDataURL('image/jpeg');

                    cropModal.hide();
                }
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');
            const kecamatanSelect = document.getElementById('kecamatan');
            const desaSelect = document.getElementById('desa');

            // --- Ambil Provinsi ---
            fetch('/api/wilayah/provinces')
                .then(res => res.json())
                .then(data => {
                    (data.data || []).forEach(prov => {
                        const opt = document.createElement('option');
                        opt.value = prov.name; // simpan NAMA
                        opt.textContent = prov.name;
                        opt.dataset.code = prov.code; // simpan kode di atribut data (untuk chaining)
                        provinsiSelect.appendChild(opt);
                    });
                });

            // --- Kabupaten berdasarkan provinsi ---
            provinsiSelect.addEventListener('change', function () {
                const provinceCode = this.selectedOptions[0]?.dataset.code;
                kabupatenSelect.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                if (!provinceCode) return;

                fetch(`/api/wilayah/regencies/${provinceCode}`)
                    .then(res => res.json())
                    .then(data => {
                        (data.data || []).forEach(kab => {
                            const opt = document.createElement('option');
                            opt.value = kab.name; // simpan NAMA
                            opt.textContent = kab.name;
                            opt.dataset.code = kab.code; // simpan kode
                            kabupatenSelect.appendChild(opt);
                        });
                    });
            });

            // --- Kecamatan berdasarkan kabupaten ---
            kabupatenSelect.addEventListener('change', function () {
                const regencyCode = this.selectedOptions[0]?.dataset.code;
                kecamatanSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                if (!regencyCode) return;

                fetch(`/api/wilayah/districts/${regencyCode}`)
                    .then(res => res.json())
                    .then(data => {
                        (data.data || []).forEach(kec => {
                            const opt = document.createElement('option');
                            opt.value = kec.name; // simpan NAMA
                            opt.textContent = kec.name;
                            opt.dataset.code = kec.code;
                            kecamatanSelect.appendChild(opt);
                        });
                    });
            });

            // --- Desa berdasarkan kecamatan ---
            kecamatanSelect.addEventListener('change', function () {
                const districtCode = this.selectedOptions[0]?.dataset.code;
                desaSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
                if (!districtCode) return;

                fetch(`/api/wilayah/villages/${districtCode}`)
                    .then(res => res.json())
                    .then(data => {
                        (data.data || []).forEach(des => {
                            const opt = document.createElement('option');
                            opt.value = des.name; // simpan NAMA
                            opt.textContent = des.name;
                            opt.dataset.code = des.code;
                            desaSelect.appendChild(opt);
                        });
                    });
            });
        });
    </script>
    <script>
        function previewFileName(input, id) {
            const label = document.getElementById(`preview-${id}`);
            if (input.files && input.files[0]) {
                label.textContent = `📄 ${input.files[0].name}`;
                label.classList.remove('text-muted');
                label.classList.add('text-success');
            } else {
                label.textContent = 'Belum ada file';
                label.classList.remove('text-success');
                label.classList.add('text-muted');
            }
        }
    </script>
@endpush

