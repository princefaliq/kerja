<script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
<script>
    let userChart;
    let statusChart;

    function getFilterParams() {
        return new URLSearchParams({
            acara_id: document.getElementById('filterAcara')?.value || '',
            tanggal_awal: document.getElementById('tanggalAwal')?.value || '',
            tanggal_akhir: document.getElementById('tanggalAkhir')?.value || ''
        });
    }

    async function loadUserData() {
        try {
            const response = await fetch("{{ route('dashboard.user.data') }}");
            const data = await response.json();

            const percent = data.percentage ?? 0;

            if (!userChart) {
                userChart = new ApexCharts(
                    document.querySelector("#userPelamarChart"),
                    {
                        series: [percent],
                        chart: {
                            height: 260,
                            type: 'radialBar',
                            sparkline: {
                                enabled: true
                            }
                        },
                        plotOptions: {
                            radialBar: {
                                startAngle: -90,
                                endAngle: 90,
                                track: {
                                    background: "#e7e7e7",
                                    strokeWidth: '97%',
                                    margin: 5,
                                },
                                hollow: {
                                    size: '60%'
                                },
                                dataLabels: {
                                    name: {
                                        show: true,
                                        offsetY: -5,
                                        color: KTUtil.getCssVariableValue('--bs-gray-500'),
                                        fontSize: "13px",
                                        fontWeight: "700",
                                        formatter: () => 'Register / Isi Biodata'
                                    },
                                    value: {
                                        offsetY: -40,
                                        fontSize: '30px',
                                        color: KTUtil.getCssVariableValue('--bs-gray-700'),
                                        fontWeight: "700",
                                        formatter: (val) => val.toFixed(1) + '%'
                                    }
                                }
                            }
                        },
                        colors: ['#4ade80'],
                        stroke: {
                            lineCap: "round"
                        }
                    }
                );

                userChart.render();
            } else {
                userChart.updateSeries([percent]);
            }

        } catch (error) {
            console.error(error);
        }
    }

    async function loadWidgetData() {
        try {

            const params = getFilterParams();

            const response = await fetch(
                "{{ route('dashboard.widget.data') }}?" + params.toString()
            );

            const data = await response.json();

            $('#countUser').text(Number(data.user ?? 0).toLocaleString('id-ID'));
            $('#countPerusahaan').text(Number(data.perusahaan ?? 0).toLocaleString('id-ID'));
            $('#countPelamar').text(Number(data.pelamar ?? 0).toLocaleString('id-ID'));
            $('#countLowongan').text(Number(data.lowongan ?? 0).toLocaleString('id-ID'));
            $('#countMelamar').text(Number(data.lamaran ?? 0).toLocaleString('id-ID'));
            $('#countAbsen').text(Number(data.absen ?? 0).toLocaleString('id-ID'));
            $('#countTerima').text(Number(data.terima ?? 0).toLocaleString('id-ID'));
            $('#countTolak').text(Number(data.tolak ?? 0).toLocaleString('id-ID'));

        } catch (error) {
            console.error(error);
        }
    }

    async function loadStatusChart() {
        try {

            const params = getFilterParams();

            const response = await fetch(
                "{{ route('dashboard.widget.data') }}?" + params.toString()
            );

            const data = await response.json();

            const series = [
                data.chart_status?.dikirim ?? 0,
                data.chart_status?.ditolak ?? 0,
                data.chart_status?.diterima ?? 0
            ];

            if (!statusChart) {

                statusChart = new ApexCharts(
                    document.querySelector("#statusLamaranChart"),
                    {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Jumlah Lamaran',
                            data: series
                        }],
                        colors: ['#007bff', '#dc3545', '#28a745'],
                        xaxis: {
                            categories: [
                                'Dikirim',
                                'Ditolak',
                                'Diterima'
                            ]
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                                columnWidth: '45%',
                                distributed: true
                            }
                        },
                        dataLabels: {
                            enabled: true
                        }
                    }
                );

                statusChart.render();

            } else {

                statusChart.updateSeries([
                    {
                        data: series
                    }
                ]);
            }

        } catch (error) {
            console.error(error);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {

        loadUserData();
        loadWidgetData();
        loadStatusChart();

        $('#btnFilter').on('click', function () {
            loadWidgetData();
            loadStatusChart();
        });

        setInterval(() => {
            loadUserData();
            loadWidgetData();
            loadStatusChart();
        }, 10000);
    });
</script>

<!--end::Vendors Javascript-->
<!--end::Custom Javascript-->
