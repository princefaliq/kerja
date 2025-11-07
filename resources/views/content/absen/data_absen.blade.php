<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tableBody = document.querySelector('#tableAbsensi tbody');

        async function loadData() {
            try {
                const res = await fetch("{{ route('absen.data') }}");
                const json = await res.json();
                const data = json.data;

                tableBody.innerHTML = '';

                if (!data || data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted">Belum ada data kehadiran</td></tr>`;
                    return;
                }

                data.forEach(item => {
                    const row = `
                    <tr>
                        <td>${item.no}</td>
                        <td>${item.nama}</td>
                        <td>${item.email}</td>
                        <td>${item.kode_acara}</td>
                        <td>${item.lokasi}</td>
                        <td class="text-end">${item.waktu_absen}</td>
                    </tr>
                `;
                    tableBody.insertAdjacentHTML('beforeend', row);
                });

            } catch (error) {
                console.error('Gagal memuat data:', error);
            }
        }

        loadData();
        setInterval(loadData, 10000); // update setiap 10 detik
    });
</script>

