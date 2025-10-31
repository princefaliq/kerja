<script>
    $(document).ready(function () {
        const datatable = $('#table_perusahaan').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('perusahaan.data') }}",
            type: "GET",
            columns: [
                { data: 'nama', orderable: false },
                { data: 'email' },
                { data: 'no_hp' },
                { data: 'last_login' },
                { data: 'tanggal_join' },
                { data: 'status', orderable: false, className: "text-center" },
                { data: 'id', orderable: false }
            ],
            columnDefs: [
                {
                    targets: -1,
                    className: "text-end",
                    render: function (data, type, full, meta) {
                        return `
                        <a href="{{ url('user') }}/${data}/edit"
                           class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"
                           title="Edit">
                            <i class="bi bi-pencil-square fs-5"></i>
                        </a>
                        <button type="button"
                                class="btn btn-icon btn-bg-light btn-active-color-danger btn-sm btn-delete"
                                data-id="${data}"
                                title="Hapus">
                            <i class="bi bi-trash3-fill fs-5"></i>
                        </button>
                    `;
                    }
                }
            ],

        });

        // 🔍 Pencarian manual
        $('#searchInput').on('keyup', function () {
            datatable.search(this.value).draw();
        });
    });

</script>

