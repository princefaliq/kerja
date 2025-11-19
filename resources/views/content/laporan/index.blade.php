@extends('master')
@section('title','Laporan')
@section('laporan','show')

@push('css')
    <style>
        /* Styling agar print-nya rapi */
        @media print {
            .no-print {
                display: none !important;
            }
            .card {
                page-break-inside: avoid;
            }
        }
    </style>
@endpush
@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Laporan List</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/app" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Laporan Management</li>
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
    <!--begin::Container-->
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
                        <div class="d-flex align-items-center position-relative my-1">
                            <h3 class="fw-bold">Laporan Pencaker</h3>
                        </div>
                        <!--end::Search-->
                    </div>
                    <!--end::Card title-->
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar">
                        <a href="{{ route('laporan.export') }}" class="btn btn-success me-2 hover-elevate-down">
                            <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
                        </a>
                        <a href="{{ route('laporan.export.summary') }}" class="btn btn-outline btn-outline-dashed btn-outline-success btn-active-light-success hover-elevate-down me-2">
                            <i class="bi bi-file-earmark-excel me-2"></i> Export Rekap (Excel)
                        </a>
                        <button onclick="printReport()" class="btn btn-primary hover-elevate-down no-print">
                            <i class="bi bi-printer me-2"></i> Cetak Laporan
                        </button>
                    </div>
                    <!--end::Card toolbar-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-5" id="reportArea">
                    <div class="row g-6 mb-6">
                        <!-- Card Laki-laki -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="bi bi-gender-male fs-1 text-primary mb-2"></i>
                                    <h4 class="fw-bold mb-0">{{ $totalLaki ?? 0 }}</h4>
                                    <div class="text-muted">Pencaker Laki-laki</div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Perempuan -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="bi bi-gender-female fs-1 text-danger mb-2"></i>
                                    <h4 class="fw-bold mb-0">{{ $totalPerempuan ?? 0 }}</h4>
                                    <div class="text-muted">Pencaker Perempuan</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total -->
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm">
                                <div class="card-body text-center">
                                    <i class="bi bi-people fs-1 text-success mb-2"></i>
                                    <h4 class="fw-bold mb-0">{{ ($totalLaki ?? 0) + ($totalPerempuan ?? 0) }}</h4>
                                    <div class="text-muted">Total Pencaker</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Pendidikan -->
                    <div class="card border-0 shadow-sm mb-6">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">Jumlah Pencaker Berdasarkan Pendidikan</h3>
                        </div>
                        <div class="card-body">
                            <div id="chartPendidikan" class="min-h-300px"></div>
                        </div>
                    </div>

                    <!-- Grafik Kabupaten -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title fw-bold">Pencaker Hadir Berdasarkan Kabupaten</h3>
                        </div>
                        <div class="card-body">
                            <div id="chartKabupaten" class="min-h-300px"></div>
                        </div>
                    </div>
                </div>

                <!--end::Card body-->
            </div>
            <!--end::Products-->
        </div>
        <!--end::Post-->
    </div>
    <!--end::Container-->
@endsection
@push('js')
    <script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script>
        const dataPendidikan = @json($dataPendidikan ?? []);
        const dataKabupaten = @json($dataKabupaten ?? []);

        // ===== Chart Pendidikan =====
        var chartPendidikan = new ApexCharts(document.querySelector("#chartPendidikan"), {
            series: [{ name: 'Jumlah', data: Object.values(dataPendidikan) }],
            chart: { type: 'bar', height: 350, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 6, columnWidth: '45%' } },
            dataLabels: { enabled: false },
            xaxis: { categories: Object.keys(dataPendidikan), labels: { style: { fontSize: '13px' } } },
            colors: ['#0d6efd'],
            yaxis: { title: { text: 'Jumlah Pencaker' } }
        });
        chartPendidikan.render();

        // ===== Chart Kabupaten =====
        var chartKabupaten = new ApexCharts(document.querySelector("#chartKabupaten"), {
            series: [{ name: 'Jumlah Hadir', data: Object.values(dataKabupaten) }],
            chart: { type: 'bar', height: 400, toolbar: { show: false } },
            plotOptions: { bar: { borderRadius: 6, horizontal: true } },
            dataLabels: { enabled: false },
            xaxis: { categories: Object.keys(dataKabupaten), labels: { style: { fontSize: '13px' } } },
            colors: ['#20c997'],
            yaxis: { title: { text: 'Kabupaten' } }
        });
        chartKabupaten.render();

        // ===== Fungsi Cetak =====
        function printReport() {
            // Tunggu chart selesai dirender
            setTimeout(() => {
                Promise.all([
                    chartPendidikan.dataURI(),
                    chartKabupaten.dataURI()
                ]).then(([pendidikanImg, kabupatenImg]) => {
                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(`
                        <html>
                            <head>
                                <title>Cetak Laporan Pencaker</title>
                                <style>
                                    body { font-family: Arial, sans-serif; margin: 30px; }
                                    h2 { text-align: center; margin-bottom: 20px; }
                                    img { width: 100%; margin: 20px 0; border: 1px solid #eee; border-radius: 10px; }
                                    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
                                    td, th { padding: 8px; border: 1px solid #ddd; text-align: center; }
                                </style>
                            </head>
                            <body>
                                <h2>Laporan Pencaker</h2>
                                <table>
                                    <tr><th>Kategori</th><th>Jumlah</th></tr>
                                    <tr><td>Pencaker Laki-laki</td><td>{{ $totalLaki ?? 0 }}</td></tr>
                                    <tr><td>Pencaker Perempuan</td><td>{{ $totalPerempuan ?? 0 }}</td></tr>
                                    <tr><td>Total</td><td>{{ ($totalLaki ?? 0) + ($totalPerempuan ?? 0) }}</td></tr>
                                </table>
                                <h3>Jumlah Pencaker Berdasarkan Pendidikan</h3>
                                <img src="${pendidikanImg.imgURI}">
                                <h3>Pencaker Hadir Berdasarkan Kabupaten</h3>
                                <img src="${kabupatenImg.imgURI}">
                            </body>
                        </html>
                    `);
                    printWindow.document.close();
                    setTimeout(() => {
                        printWindow.focus();
                        printWindow.print();

                        // Tunggu sedikit agar proses print selesai, lalu tutup tab
                        setTimeout(() => {
                            printWindow.close();
                        }, 100);
                    }, 500);
                });
            }, 600);
        }
    </script>
@endpush



