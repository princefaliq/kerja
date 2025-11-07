@push('css')
    <style>
        .btn-kirim {
            transition: all 0.3s ease;
        }

        .btn-kirim:hover {
            background-color: #157347 !important; /* Warna lebih gelap dari base-color */
            color: #fff !important; /* pastikan teks tetap putih */
        }

        .btn-kirim:hover i {
            color: #fff !important; /* pastikan icon tetap terlihat */
        }

    </style>
@endpush
<!-- start section -->
<section class="bg-dark-midnight-blue overflow-hidden">
    <div class="container">
        <div class="row align-items-center">
            <!-- Kiri: Judul & Tombol -->
            <div class="col-xxl-4 col-lg-5 position-relative text-center text-lg-start"
                 data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <h2 class="alt-font fw-500 text-white ls-minus-2px">
                    <span class="w-20px h-4px d-inline-block bg-base-color me-10px"></span>
                    Testimoni peserta kami
                </h2>

                <!-- Navigasi Slider -->
                <div class="d-flex md-mb-30px justify-content-center justify-content-lg-start">
                    <div class="slider-one-slide-prev-1 text-white swiper-button-prev slider-navigation-style-04 border border-2 border-color-transparent-white-light">
                        <i class="fa-solid fa-arrow-left"></i>
                    </div>
                    <div class="slider-one-slide-next-1 text-white swiper-button-next slider-navigation-style-04 border border-2 border-color-transparent-white-light">
                        <i class="fa-solid fa-arrow-right"></i>
                    </div>
                </div>

                <!-- Tombol Tambah Testimoni -->
                <div class="text-center mt-5 mb-5">
                    @guest
                        <a href="{{ route('login') }}"
                           class="btn btn-medium btn-round-edge btn-base-color btn-box-shadow text-transform-none d-inline-flex align-items-center gap-2">
                            <i class="feather icon-feather-edit fs-18"></i>
                            <span>Testimoni</span>
                        </a>
                    @else
                        <button type="button" data-bs-toggle="modal" data-bs-target="#modalTestimoni"
                            class="btn btn-medium btn-round-edge btn-base-color btn-box-shadow text-transform-none d-inline-flex align-items-center gap-2">
                        <i class="feather icon-feather-edit fs-18"></i>
                        <span>Testimoni</span>
                        </button>
                    @endguest

                </div>
            </div>

            <!-- Kanan: Daftar Testimoni -->
            <div class="col-lg-7 offset-xxl-1"
                 data-anime='{ "translateX": [0, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="outside-box-right-20 lg-outside-box-right-10 md-outside-box-right-0">
                    <div class="swiper magic-cursor light slider-one-slide ps-5px md-ps-0"
                         data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loopedSlides": true, "navigation": { "nextEl": ".slider-one-slide-next-1", "prevEl": ".slider-one-slide-prev-1" }, "autoplay": { "delay": 3000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 3 }, "992": { "slidesPerView": 2 }, "768": { "slidesPerView": 2 }, "320": { "slidesPerView": 1 } }, "effect": "slide" }'>
                        <div class="swiper-wrapper">
                            @forelse($testimonis as $item)
                                <div class="swiper-slide review-style-04">
                                    <div class="d-flex justify-content-center h-100 flex-column border-radius-6px p-12 xl-p-10 border border-color-transparent-white-light">
                                        <p class="text-white opacity-80 fst-italic">“{{ $item->isi }}”</p>
                                        <div class="d-flex align-items-center mt-3">
                                            <img class="rounded-circle w-70px h-70px me-20px"
                                                 src="{{ $item->user->avatarUrl ?? 'https://placehold.co/125x125' }}" alt="">
                                            <div class="d-inline-block align-middle">
                                                <div class="text-white fw-500">{{ $item->user->name }}</div>
                                                <div class="lh-20 fs-16 text-white opacity-70">
                                                    {{ $item->user->pekerjaan ?? 'Peserta' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="swiper-slide review-style-04">
                                    <div class="text-white opacity-70 text-center p-5 border border-color-transparent-white-light rounded-3">
                                        Belum ada testimoni.
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end section -->

<!-- Modal Tambah Testimoni -->
<!-- Modal Testimoni -->
<div class="modal fade" id="modalTestimoni" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <!-- Header -->
            <div class="modal-header bg-base-color text-white py-3 px-4">
                <h5 class="modal-title fw-600">
                    <i class="feather icon-feather-edit me-2"></i> Tulis Testimoni
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body p-4">
                <p class="text-dark mb-4">
                    Bagikan pengalaman Anda menggunakan layanan kami.
                </p>
                <form id="formTestimoni" action="{{ route('testimoni.store') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-500 text-dark">Isi Testimoni</label>
                        <textarea class="form-control rounded-3 border border-color-extra-medium-gray"
                                  name="isi"
                                  rows="4"
                                  placeholder="Tulis testimoni Anda..."
                                  required></textarea>
                    </div>
                    <div class="d-flex justify-content-end align-items-center gap-2 mt-4">
                        <button type="button" class="btn btn-light btn-sm fw-500 px-4 d-inline-flex align-items-center gap-2" data-bs-dismiss="modal">
                            <i class="feather icon-feather-x-circle fs-16"></i>
                            <span>Batal</span>
                        </button>

                        <button type="submit" class="btn btn-base-color btn-sm text-white fw-500 px-4 d-inline-flex align-items-center gap-2 btn-kirim">
                            <i class="feather icon-feather-send fs-16"></i>
                            <span>Kirim</span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#157347',
            });
            @endif

            @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33',
            });
            @endif
        });
    </script>
@endpush


