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

                document.getElementById('countUser').textContent = Number(data.user ?? 0).toLocaleString('id-ID');
                document.getElementById('countPerusahaan').textContent = Number(data.perusahaan ?? 0).toLocaleString('id-ID');
                document.getElementById('countPelamar').textContent = Number(data.pelamar ?? 0).toLocaleString('id-ID');
                document.getElementById('countLowongan').textContent = Number(data.lowongan ?? 0).toLocaleString('id-ID');
                document.getElementById('countMelamar').textContent = Number(data.lamaran ?? 0).toLocaleString('id-ID');
                document.getElementById('countAbsen').textContent = Number(data.absen ?? 0).toLocaleString('id-ID');
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


<!--end::Vendors Javascript-->
<!--end::Custom Javascript-->
