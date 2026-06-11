@php
    $endDate = null;

    if ($acara && $acara->tanggal_selesai && $acara->waktu_selesai) {
        $endDate = \Carbon\Carbon::parse(
            $acara->tanggal_selesai . ' ' . $acara->waktu_selesai
        )->format('Y/m/d H:i:s');
    }
@endphp
<!-- start section -->
<section class="position-relative" data-parallax-background-ratio="0.5" style="background-image: url({{ url('logo/bg_kerja.jpg') }})" data-anime='{ "translateY": [0, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-xl-8 col-lg-12 text-center position-relative last-paragraph-no-margin parallax-scrolling-style-2">
                <!-- start countdown item -->
                @if($endDate)
                    <div class="countdown-style-02 mb-30px mt-40px sm-mb-10px">
                        <div data-enddate="{{ $endDate }}" class="countdown"></div>
                    </div>
                @endif
                <!-- end countdown item -->
                @if($acara)
                    <h1 class="alt-font text-white fw-500 mb-50px sm-mb-40px ls-minus-2px">
                        <span class="text-golden-yellow">
                            {{ strtoupper($acara->nama_acara) }}
                        </span>
                        <br>
                        Jangan lewatkan peluang karier yang berharga!
                    </h1>
                @endif
                {{--<a href="demo-conference-registration.html" class="btn btn-extra-large btn-rounded btn-base-color btn-hover-animation btn-box-shadow align-self-center">
                            <span>
                                <span class="btn-text">Get tickets now</span>
                                <span class="btn-icon"><i class="fa-solid fa-arrow-right"></i></span>
                            </span>
                </a>--}}
            </div>
        </div>
    </div>
</section>
<!-- end section -->
