<script>
    $(document).ready(function () {
        const datatable = $('#table_pelamar').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pelamar.data') }}",
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

                        let buttonStatus = '';
                        let buttonClean = '';

                        if (full.status.includes('Diblokir')) {

                            buttonStatus = `
                    <button type="button"
                            class="btn btn-icon btn-light-success btn-sm btn-toggle-status me-1"
                            data-id="${data}"
                            title="Buka Blokir">
                        <i class="bi bi-unlock-fill fs-5"></i>
                    </button>
                `;

                            buttonClean = `
                    <button type="button"
                            class="btn btn-icon btn-light-warning btn-sm btn-clean-files"
                            data-id="${data}"
                            title="Bersihkan File">
                        <i class="bi bi-fire fs-5"></i>
                    </button>
                `;

                        } else {

                            buttonStatus = `
                    <button type="button"
                            class="btn btn-icon btn-light-danger btn-sm btn-toggle-status"
                            data-id="${data}"
                            title="Blokir Akun">
                        <i class="bi bi-lock-fill fs-5"></i>
                    </button>
                `;
                        }

                        return `
                <div class="d-flex justify-content-end gap-2">
                    ${buttonStatus}
                    ${buttonClean}
                </div>
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
    $(document).on('click', '.btn-toggle-status', function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Ubah Status?',
            text: 'Status akun pelamar akan diblokir.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: `/app/pelamar/${id}/toggle-block`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message,
                            timer: 1500,
                            showConfirmButton: false
                        });

                        $('#table_pelamar').DataTable().ajax.reload(null, false);
                    },
                    error: function () {

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Terjadi kesalahan.'
                        });
                    }
                });

            }

        });

    });
    $(document).on('click', '.btn-clean-files', function () {

        let id = $(this).data('id');

        Swal.fire({
            title: 'Bersihkan File?',
            text: 'Semua file upload pelamar akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "{{ route('pelamar.clean-files', ':id') }}".replace(':id', id),
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function (response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.message
                        });

                    },
                    error: function (xhr) {

                        let message = 'Terjadi kesalahan.';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: message
                        });
                    }
                });

            }
        });
    });
</script>

