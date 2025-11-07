@extends('master')
@section('title','Qr Code Absen')
@section('absen','show')

@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">QR Code Absen</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Absen</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Qr Code</li>
                    <!--end::Item-->

                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->

            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('content')
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Products-->
            <div class="card card-flush">
                <!--begin::Card header-->
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <h3 class="mb-4 text-primary">QR Code Kehadiran</h3>
                    </div>
                    <!--end::Card title-->

                </div>

                <div class="card-body pt-0">
                    <div class="container text-center mt-5">
                        <div class="card p-4 shadow-sm d-inline-block">
                            <h5 class="mb-2">Selamat Datang</h5>
                            <p class="text-danger mb-3">Scan di bawah dengan tombol yang ada pada menu profil anda!</p>

                            <div id="qrContainer" class="border rounded p-2 bg-white shadow-sm" style="display:inline-block;"></div>

                            <div class="mt-4">
                                <p id="qrTimer" class="mt-3 text-muted"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrContainer = document.getElementById('qrContainer');
            const qrTimer = document.getElementById('qrTimer');
            let intervalId = null;
            let statusChecker = null;

            async function updateQR() {
                if (intervalId) clearInterval(intervalId);
                if (statusChecker) clearInterval(statusChecker);

                try {
                    const res = await fetch("{{ route('absen.qr.generate') }}");
                    const data = await res.json();

                    qrContainer.innerHTML = data.qr;
                    const svg = qrContainer.querySelector('svg');
                    if (svg) {
                        svg.setAttribute('width', '250');
                        svg.setAttribute('height', '250');
                        svg.style.display = 'block';
                        svg.style.margin = '0 auto';
                    }

                    const ttl = data.ttl_seconds ?? 60;
                    const targetTime = Date.now() + ttl * 1000;
                    startTimer(targetTime);

                    // mulai cek status token aktif
                    startStatusCheck();
                } catch (e) {
                    console.error(e);
                }
            }

            function startTimer(targetTime) {
                function tick() {
                    const diff = Math.floor((targetTime - Date.now()) / 1000);
                    if (diff <= 0) {
                        clearInterval(intervalId);
                        qrTimer.textContent = '⏳ Memperbarui QR...';
                        setTimeout(updateQR, 1000);
                    } else {
                        qrTimer.textContent = `QR berlaku ${diff}s lagi`;
                    }
                }
                tick();
                intervalId = setInterval(tick, 1000);
            }

            function startStatusCheck() {
                statusChecker = setInterval(async () => {
                    try {
                        const res = await fetch("{{ route('absen.qr.status') }}");
                        const data = await res.json();

                        if (!data.active) {
                            clearInterval(statusChecker);
                            clearInterval(intervalId);
                            qrTimer.textContent = "✅ QR telah digunakan, membuat baru...";
                            setTimeout(updateQR, 1000);
                        }
                    } catch (err) {
                        console.error(err);
                    }
                }, 5000); // cek tiap 5 detik
            }

            updateQR();
        });
    </script>

@endpush

