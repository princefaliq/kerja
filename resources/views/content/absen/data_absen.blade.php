<script>
    $(document).ready(function() {
        // Inisialisasi DataTable
        const table = $('#tableAbsensi').DataTable({
            processing: true,
            ajax: {
                url: "{{ route('absen.data') }}",
                dataSrc: 'data' // pastikan response JSON punya key "data"
            },
            columns: [
                { data: 'no', title: 'No' },
                { data: 'nama', title: 'Nama' },
                { data: 'email', title: 'Email' },
                { data: 'kode_acara', title: 'Kode Acara' },
                { data: 'lokasi', title: 'Lokasi' },
                { data: 'waktu_absen', title: 'Waktu Absen', className: 'text-end' }
            ],

            order: [[0, 'asc']],
            pageLength: 10,
            language: {
                search: "Cari:",
                emptyTable: "Belum ada data kehadiran"
            }
        });
        $('[data-kt-ecommerce-product-filter="search"]').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Reload otomatis tiap 10 detik
        setInterval(() => table.ajax.reload(null, false), 10000);
    });
</script>

