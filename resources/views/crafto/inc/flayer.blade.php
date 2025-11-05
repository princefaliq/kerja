<section class="big-section overflow-hidden bg-dark-midnight-blue">
    <div class="container">
        <div class="row align-items-center mb-6">
            <div class="col-md-9 last-paragraph-no-margin">
                <h3 class="text-light fw-600 ls-minus-1px mb-20px">Info Spesial Untuk Anda</h3>
                <p class="w-95 sm-w-100 text-yellow">Simak berbagai kegiatan, pengumuman, dan informasi menarik terbaru di halaman ini.</p>
            </div>
            <div class="col-md-3 text-center d-none d-md-inline-block">
                <img src="{{ url('logo/logo_kerja_berkah.png') }}" alt=""/>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 position-relative" data-anime='{ "el": "childs", "translateX": [100, 0], "opacity": [0,1], "duration": 600, "delay": 100, "staggervalue": 200, "easing": "easeOutQuad" }'>
                <div class="outside-box-right-30">
                    <div class="swiper image-gallery-style-05" data-slider-options='{ "slidesPerView": 1, "spaceBetween": 25, "loop": true, "autoplay": { "delay": 4000, "disableOnInteraction": false },"pagination": { "el": ".slider-three-slide-pagination", "clickable": true, "dynamicBullets": false }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "992": { "slidesPerView": 4 }, "768": { "slidesPerView": 3 }, "320": { "slidesPerView": 2 } }, "effect": "slide" }' data-gallery-box="true">
                        <div class="swiper-wrapper">
                            @for ($i = 1; $i <= 11; $i++)
                                <!-- start gallery item -->
                                <div class="swiper-slide transition-inner-all">
                                    <div class="gallery-box">
                                        <a href="{{ url('storage/uploads/flayer/'.$i.'.jpg') }}" data-group="lightbox-group-gallery-item-{{ $i }}" title="Lightbox gallery image title">
                                            <div class="position-relative bg-dark-gray border-radius-6px overflow-hidden">
                                                <img src="{{ url('storage/uploads/flayer/'.$i.'.jpg') }}" alt="Image {{ $i }}" />
                                                <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-bottom-top">
                                                    <i class="feather icon-feather-search icon-very-medium text-white"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <!-- end gallery item -->
                            @endfor
                            {{--<!-- start gallery item -->
                            <div class="swiper-slide transition-inner-all">
                                <div class="gallery-box">
                                    <a href="https://placehold.co/600x745" data-group="lightbox-group-gallery-item-5" title="Lightbox gallery image title">
                                        <div class="position-relative bg-dark-gray border-radius-6px overflow-hidden">
                                            <img src="https://placehold.co/600x745" alt="" />
                                            <div class="d-flex align-items-center justify-content-center position-absolute top-0px left-0px w-100 h-100 gallery-hover move-bottom-top">
                                                <i class="feather icon-feather-search icon-very-medium text-white"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <!-- end gallery item -->--}}

                        </div>
                    </div>
                </div>
                <!-- start slider pagination -->
                <!--<div class="swiper-pagination slider-three-slide-pagination swiper-pagination-style-2 swiper-pagination-clickable swiper-pagination-bullets"></div>-->
                <!-- end slider pagination -->
            </div>
        </div>
    </div>
</section>
