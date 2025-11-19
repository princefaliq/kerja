<script src="{{ url('assets/plugins/global/plugins.bundle.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // === BAGIAN CHART PERSENTASE PELAMAR ===
        let chart; // Simpan instance chart agar bisa di-update tanpa render ulang

        async function loadUserData() {
            try {
                const response = await fetch("{{ route('dashboard.user.data') }}");
                const data = await response.json();

                const percent = data.percentage ?? 0;

                // Jika chart belum ada → render baru
                if (!chart) {
                    const options = {
                        series: [percent],
                        chart: {
                            height: 260,
                            type: 'radialBar',
                            sparkline: { enabled: true },
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
                                hollow: { size: '60%' },
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
                                        show: true,
                                        formatter: function (val) {
                                            return val.toFixed(1) + '%';
                                        }
                                    }
                                }
                            }
                        },
                        colors: ['#4ade80'],
                        stroke: { lineCap: "round" },
                    };

                    chart = new ApexCharts(document.querySelector("#userPelamarChart"), options);
                    chart.render();
                } else {
                    // Jika chart sudah ada → update datanya
                    chart.updateSeries([percent]);
                }
            } catch (error) {
                console.error('Error fetching user data:', error);
            }
        }

        // === BAGIAN WIDGET COUNT ===
        async function loadWidgetData() {
            try {
                const response = await fetch("{{ route('dashboard.widget.data') }}");
                const data = await response.json();
                console.log(data);
                document.getElementById('countUser').textContent = Number(data.user ?? 0).toLocaleString('id-ID');
                document.getElementById('countPerusahaan').textContent = Number(data.perusahaan ?? 0).toLocaleString('id-ID');
                document.getElementById('countPelamar').textContent = Number(data.pelamar ?? 0).toLocaleString('id-ID');
                document.getElementById('countLowongan').textContent = Number(data.lowongan ?? 0).toLocaleString('id-ID');
                document.getElementById('countMelamar').textContent = Number(data.lamaran ?? 0).toLocaleString('id-ID');
                document.getElementById('countAbsen').textContent = Number(data.absen ?? 0).toLocaleString('id-ID');
                document.getElementById('countTerima').textContent = Number(data.terima ?? 0).toLocaleString('id-ID');
                document.getElementById('countTolak').textContent = Number(data.tolak ?? 0).toLocaleString('id-ID');
            } catch (error) {
                console.error('Error fetching widget data:', error);
            }
        }

        // === Panggil pertama kali ===
        loadUserData();
        loadWidgetData();

        // === Update setiap 10 detik ===
        setInterval(() => {
            loadUserData();
            loadWidgetData();
        }, 10000);
    });
</script>

<script>
    let statusChart;

    // Load data chart
    async function loadStatusChart() {
        try {
            const response = await fetch("{{ route('dashboard.widget.data') }}");
            const data = await response.json();

            const chartData = data.chart_status;

            const series = [
                chartData.dikirim ?? 0,
                chartData.ditolak ?? 0,
                chartData.diterima ?? 0
            ];

            const options = {
                chart: {
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: 'Jumlah Lamaran',
                    data: series
                }],
                // 🎨 WARNA BAR
                colors: ['#007bff', '#dc3545', '#28a745'],

                xaxis: {
                    categories: ['Dikirim', 'Ditolak', 'Diterima']
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '45%',
                        endingShape: 'rounded',
                        distributed: true // ⬅ WAJIB untuk warna per bar
                    }
                },
                dataLabels: {
                    enabled: true
                }
            };

            // Jika chart belum dirender → render
            if (!statusChart) {
                statusChart = new ApexCharts(
                    document.querySelector("#statusLamaranChart"),
                    options
                );
                statusChart.render();

                // Jika chart sudah ada → update saja
            } else {
                statusChart.updateSeries([{ data: series }]);
            }

        } catch (error) {
            console.error("Error load chart:", error);
        }
    }

    // Load pertama kali
    loadStatusChart();

    // Auto refresh tiap 10 detik (opsional)
    setInterval(() => {
        loadStatusChart();
    }, 10000);
</script>

<!--end::Vendors Javascript-->
<!--end::Custom Javascript-->
