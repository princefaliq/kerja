@push('css')

@endpush
<!-- start section -->
<section class="p-0 full-screen ipad-top-space-margin md-h-600px sm-h-500px position-relative bg-base-color background-position-left-top" style="background-image: url('crafto/images/vertical-line-bg-dark.svg')">
    <div id="particles-style-01" class="position-absolute h-100 top-0 left-0 w-100" data-particle="true" data-particle-options='{ "particles": { "number": { "value": 80, "density": { "enable": true, "value_area": 800 } }, "color": { "value": "#232323" }, "shape": { "type": "circle", "stroke": { "width": 0, "color": "#232323" }, "polygon": { "nb_sides": 5 }, "image": { "src": "img/github.svg", "width": 100, "height": 100 } }, "opacity": { "value": 0.4, "random": false, "anim": { "enable": false, "speed": 1, "opacity_min": 0.1, "sync": false } }, "size": { "value": 4, "random": true, "anim": { "enable": false, "speed": 40, "size_min": 0.1, "sync": false } }, "line_linked": { "enable": true, "distance": 150, "color": "#232323", "opacity": 0.3, "width": 1 }, "move": { "enable": true, "speed": 6, "direction": "none", "random": false, "straight": false, "out_mode": "out", "bounce": false, "attract": { "enable": false, "rotateX": 600, "rotateY": 1200 } } }, "interactivity": { "detect_on": "canvas", "events": { "onhover": { "enable": true, "mode": "repulse" }, "onclick": { "enable": true, "mode": "push" }, "resize": true }, "modes": { "grab": { "distance": 400, "line_linked": { "opacity": 1 } }, "bubble": { "distance": 400, "size": 40, "duration": 2, "opacity": 8, "speed": 3 }, "repulse": { "distance": 200, "duration": 0.4 }, "push": { "particles_nb": 4 }, "remove": { "particles_nb": 2 } } }, "retina_detect": true}'></div>
    <div class="absolute-middle-center p-7 lg-p-0 sm-w-60 xs-w-80">
        <div class="animation-float mb-4">
            <img src="{{ url('logo/kerja.png') }}" class="rounded-circle img-fluid"
                 alt="Kerja Berkah"
                 data-anime='{ "opacity": [0, 1], "scale": [0.5, 1], "easing": "easeOutCubic", "duration": 1000 }' />
        </div>
    </div>

</section>
@push('js1')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const el = document.getElementById('dateLocation');
            const LOCALE = 'id-ID'; // ubah ke 'id-ID' jika ingin bulan dalam Bahasa Indonesia

            function formatDate(date) {
                const opts = { day: 'numeric', month: 'long', year: 'numeric' };
                return new Intl.DateTimeFormat(LOCALE, opts).format(date);
            }

            function updateDisplay(locationText = '') {
                const now = new Date();
                const dateText = formatDate(now);
                const finalText = locationText ? `${dateText}, ${locationText}` : dateText;
                el.innerHTML = `<i class="feather icon-feather-calendar icon-small me-5px"></i>${finalText}`;
            }

            // tampilkan tanggal dulu
            updateDisplay();

            // ambil lokasi berdasarkan IP
            fetch('https://ipapi.co/json/')
                .then(resp => resp.json())
                .then(data => {
                    const city = data.city || '';
                    const region = data.region || '';
                    const country = data.country_name || data.country || '';
                    let loc = city;
                    if (region && region !== city) loc += (loc ? ', ' : '') + region;
                    if (country) loc += (loc ? ', ' : '') + country;
                    updateDisplay(loc);
                })
                .catch(() => updateDisplay()); // jika gagal ambil lokasi, tampilkan tanggal saja
        });
    </script>
@endpush
