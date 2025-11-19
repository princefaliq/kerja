<script>
    $(document).ready(function() {
        const table = $('#tableAcara').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('app/acara') }}",
                type: 'GET'
            },
            columns: [
                {
                    data: 'id',
                    render: (data, type, row, meta) => meta.row + 1
                },
                { data: 'nama_acara', name: 'nama_acara' },
                {
                    data: 'tanggal_mulai',
                    className: "text-center",
                    render: function(data, type, row) {
                        return `${row.tanggal_mulai} s/d ${row.tanggal_selesai}`
                    }
                },
                { data: 'waktu_mulai', className: "text-center", name: 'waktu_mulai' },
                { data: 'waktu_selesai', className: "text-center", name: 'waktu_selesai' },
                {
                    data: 'id',
                    className: "text-center",
                    render: function (data) {
                        const url = "{{ url('/') }}";
                        return `
                            <a href="${url}/app/acara/${data}/edit"
                               class="btn btn-icon hover-scale btn-active-light-primary me-1"
                               title="Edit">
                                <i class="bi bi-pencil text-primary"></i>
                            </a>
                            <a href="#" data-id="${data}"
                               class="btn btn-icon hover-scale btn-active-light-danger btn-delete"
                               title="Hapus">
                                <i class="bi bi-trash text-danger"></i>
                            </a>
                        `;
                    }
                }
            ]
        });

        // Search
        $('[data-acara-search]').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Delete handler
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            let id = $(this).data('id');

            Swal.fire({
                title: "Hapus Acara?",
                text: "Data "+id+" yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-secondary"
                },
                buttonsStyling: false
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "{{ url('app/acara') }}/" + id,
                        type: "POST",
                        data: {
                            _method: "DELETE",
                            _token: "{{ csrf_token() }}"
                        },
                        success: function() {

                            Swal.fire({
                                title: "Berhasil!",
                                text: "Acara telah dihapus.",
                                icon: "success",
                                timer: 1500,
                                showConfirmButton: false
                            });

                            table.ajax.reload();
                        },
                        error: function() {
                            Swal.fire({
                                title: "Gagal!",
                                text: "Terjadi kesalahan saat menghapus.",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        }
                    });

                }

            });

        });

    });
</script>
