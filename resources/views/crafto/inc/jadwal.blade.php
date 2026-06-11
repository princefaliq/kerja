<!-- start section -->
<section class="p-0 bg-dark-midnight-blue border-bottom border-color-transparent-white-light background-position-left-bottom background-no-repeat overflow-hidden"
         style="background-image: url('{{ url('logo/demo-conference-schedule-bg.png') }}')">

    <div class="container-fluid">
        <div class="row justify-content-center"
             data-anime='{ "el": "childs", "translateX": [50, 0], "opacity": [0,1], "duration": 1200, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>

            <!-- Info Jadwal -->
            <div class="col-xl-3 p-0">
                <div class="ps-20 pe-20 pt-25 pb-25 xxl-ps-15 xxl-pe-15 lg-p-7 sm-p-40px overflow-hidden h-100 text-center text-xl-start border-top border-end border-color-transparent-white-light">
                    <h2 class="alt-font fw-500 text-white ls-minus-2px">
                        <span class="w-20px h-4px d-inline-block bg-base-color me-10px"></span>
                        Jadwal Event
                    </h2>

                    <p class="mb-35px lg-w-50 md-w-70 sm-w-100 mx-auto mx-xl-auto">
                        Jadwal event dapat berubah sesuai kondisi terkini.
                        Mohon pantau informasi terbaru!
                    </p>
                </div>
            </div>

            @forelse($jadwalAcara as $index => $item)

                <div class="col-xl-3 col-md-4 event-style-01 p-0">
                    <div class="bg-dark-midnight-blue hover-box will-change-inherit dark-hover feature-box ps-19 pe-19 pt-22 pb-27 md-p-8 md-pb-25 sm-pb-50px overflow-hidden h-100 text-center text-md-start border-top border-end border-color-transparent-white-light">

                        <div class="feature-box-content w-100 lg-mb-5 last-paragraph-no-margin">

                            <div class="text-white fs-22 alt-font fw-500 mb-20px">
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->locale('id')->translatedFormat('l, d M Y') }}
                            </div>

                            <p class="text-light-opacity">
                                {{ strtoupper($item->nama_acara) }}
                                <br>
                                {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }} WIB
                                <br>
                                {{ $item->lokasi }}
                            </p>

                            <span class="number fs-120 ls-minus-5px fw-500 text-outline text-outline-width-2px text-outline-color-base-color opacity-5 alt-font position-absolute bottom-minus-50px sm-bottom-minus-40px left-0px ps-20 sm-ps-0 sm-right-0px sm-left-0px">
                                {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>

                        </div>

                        <div class="feature-box-overlay bg-base-color"></div>
                    </div>
                </div>

            @empty

                <div class="col-xl-9 p-5 text-center border-top border-color-transparent-white-light">
                    <h5 class="text-white mb-0">
                        Belum ada jadwal acara yang akan datang.
                    </h5>
                </div>

            @endforelse

        </div>
    </div>
</section>
<!-- end section -->
