<section class="bg-dark-midnight-blue overflow-hidden xs-pb-20px">
    <div class="container-fluid">
        <div class="row justify-content-center mb-2">
            <div class="col-xxl-4 col-xl-5 col-lg-6 col-sm-8 text-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>

                <h3 class="alt-font text-light fw-600 ls-minus-1px mb-0">Lowongan kerja terbaru</h3>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 position-relative" data-anime='{ "translateX": [50, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                <div class="swiper slider-three-slide swiper-initialized swiper-horizontal" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 30, "loopedSlides": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": true, "dynamicBullets": false }, "autoplay": { "delay": 3000, "disableOnInteraction": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 } }, "effect": "slide" }'>
                    <div class="swiper-wrapper pt-30px pb-30px">
                        <div class="swiper-slide review-style-04 d-none d-lg-block h-auto"></div>
                        @foreach($lowongans as $lowongan)
                            <!-- start review item -->
                            <div class="swiper-slide review-style-04">
                                <div class="d-flex justify-content-center bg-transparent hover-box h-100 flex-column hover-box will-change-inherit dark-hover border-left-5 border-top border-end border-color-transparent-white-light border-radius-6px p-15 xl-p-12 box-shadow-extra-large">
                                    {{--<div class="review-star-icon fs-18 lh-30">
                                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                    </div>--}}
                                    <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="alt-font fw-500 fs-19 text-light mb-10px">
                                        {{ Str::limit($lowongan->judul, 30, '...') }}
                                    </a>
                                    <div class="mb-10px text-light border-bottom border-light">
                                        <p class="mb-10px">Lokasi : {{ Str::limit($lowongan->lokasi, 20, '...') }}</p>
                                        <p class="mb-10px">Rentang Gaji : {{ $lowongan->rentang_gaji ? $lowongan->rentang_gaji : 'Dirahasiakan' }}</p>
                                        {{--<p class="mb-10px">Batas lamaran :{{ \Carbon\Carbon::parse($lowongan->batas_lamaran)->translatedFormat('d F Y') }} </p>--}}
                                        <p class="mb-10px">
                                            @php
                                                $batas = $lowongan->batas_lamaran->endOfDay();
                                            @endphp
                                            @if ($batas->isFuture())
                                                Batas Lamaran:
                                                {{ now()->diffForHumans($batas, [
                                                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                                    'parts' => 2
                                                ]) }}
                                            @else
                                                Melewati batas:
                                                {{ $batas->diffForHumans(now(), [
                                                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                                                    'parts' => 2
                                                ]) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <img class="rounded-circle w-90px h-90px me-20px" src="{{ $lowongan->user->avatar_url ? asset($lowongan->user->avatar_url) : 'https://placehold.co/58x58' }}" alt="">
                                        <div class="d-inline-block align-middle">
                                            <div class="text-light-gray fw-500 alt-font">{{ $lowongan->user->name }}</div>
                                            <div class="lh-20 fs-16 text-base-color">{{ $lowongan->bidang_pekerjaan }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-5px text-center">
                                        <a href="{{ url('lowongan-kerja/'.$lowongan->slug) }}" class="bg-yellow box-shadow-quadruple-large text-uppercase fs-13 ps-25px pe-25px alt-font fw-600 text-dark lh-40 sm-lh-55 border-radius-100px d-inline-block ">Detail</a>
                                    </div>
                                </div>
                            </div>
                            <!-- end review item -->
                        @endforeach


                        <div class="swiper-slide review-style-04 d-none d-lg-block h-auto"></div>
                    </div>
                    <!-- start slider pagination -->
                    <!--<div class="swiper-pagination slider-four-slide-pagination-2 swiper-pagination-style-2 swiper-pagination-clickable swiper-pagination-bullets"></div>-->
                    <!-- end slider pagination -->
                </div>
            </div>
        </div>
        <div class="text-center">
            <a href="{{ url('lowongan-kerja') }}" class="btn btn-large btn-base-color btn-hover-animation btn-round-edge btn-box-shadow align-self-center mt-5">
                            <span>
                                <span class="btn-text">Lowongan Lainnya</span>
                                <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                            </span>
            </a>
{{--            <a href="{{ url('lowongan-kerja') }}" class="btn btn-large btn-dark-gray btn-hover-animation btn-round-edge btn-box-shadow align-self-center mt-5">Lowongan Lainnya</a>--}}
        </div>

    </div>
</section>
<!-- start section -->
