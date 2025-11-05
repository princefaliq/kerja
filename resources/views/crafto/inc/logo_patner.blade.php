<section class="bg-dark-midnight-blue background-position-right-bottom background-no-repeat sm-background-image-none" >
    <div class="container">
        <div class="row position-relative clients-style-08">
            <div class="col swiper text-center feather-shadow" id="perusahaan-swiper"
                 data-slider-options='{ "slidesPerView": 2, "spaceBetween":0, "speed": 4000, "loop": true, "allowTouchMove": true, "autoplay": { "delay":0, "disableOnInteraction": false }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 } }, "effect": "slide" }'>
                <div class="swiper-wrapper marquee-slide" id="perusahaan-list">
                     Data akan dimasukkan lewat AJAX
                    <div class="swiper-slide text-center py-5">

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- start section -->
{{--<section class="bg-dark-midnight-blue background-position-right-bottom background-no-repeat sm-background-image-none" style="background-image: url('logo/demo-conference-about-bg.png')">
    <div class="container">
        <div class="row position-relative clients-style-08">
            <div class="col swiper text-center feather-shadow" data-slider-options='{ "slidesPerView": 2, "spaceBetween":0, "speed": 4000, "loop": true, "pagination": { "el": ".slider-four-slide-pagination-2", "clickable": false }, "allowTouchMove": false, "autoplay": { "delay":0, "disableOnInteraction": false }, "navigation": { "nextEl": ".slider-four-slide-next-2", "prevEl": ".slider-four-slide-prev-2" }, "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1200": { "slidesPerView": 4 }, "992": { "slidesPerView": 3 }, "768": { "slidesPerView": 2 } }, "effect": "slide" }'>
                <div class="swiper-wrapper marquee-slide">
                    <!-- start client item -->
                    <div id="perusahaan-swiper">
                        <div class="swiper-slide">
                            <a href="#"><img src="https://placehold.co/600x600" class="h-100px xs-h-30px" alt=""></a>
                        </div>
                    </div>
                     <!-- end client item -->
                 </div>
                <!-- end client item -->
            </div>
        </div>
    </div>
</section>--}} <!-- end section -->
@push('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            fetch("{{ route('perusahaan.list') }}")
                .then(res => res.json())
                .then(data => {

                    const container = document.getElementById("perusahaan-list");
                    container.innerHTML = "";
                    const baseUrl = "{{ url('perusahaan/') }}/";
                    data.forEach(item => {
                        const slide = `
                <div class="swiper-slide">
                    <a href="${baseUrl+item.id}" title="${item.name}">
                        <img src="${item.avatar_url}" alt="${item.name}"
                            class="h-100px xs-h-30px"
                            >
                    </a>
                </div>`;
                        container.insertAdjacentHTML("beforeend", slide);
                    });
                    // 🌀 Re-init Swiper setelah elemen baru dimasukkan
                    setTimeout(() => {
                        const el = document.getElementById('perusahaan-swiper');
                        const options = JSON.parse(el.dataset.sliderOptions || '{}');
                        new Swiper(el, options);
                    }, 100);
                })
                .catch(err => console.error('Gagal memuat data perusahaan:', err));
        });
    </script>

@endpush
