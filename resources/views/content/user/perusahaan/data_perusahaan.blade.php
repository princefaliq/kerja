<script>
    $(document).ready(function () {
        const table = $('#table_perusahaan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('perusahaan.data') }}",
                type: "GET"
            },
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'email', name: 'email' },
                { data: 'no_hp', name: 'no_hp' },
                { data: 'last_login', name: 'last_login' },
                { data: 'tanggal_join', name: 'tanggal_join' },
                { data: 'status', name: 'status' },
                /*{
                    data: 'status',
                    className: "text-center",
                    render: function(data) {
                        return data === 'aktif'
                            ? '<span class="badge badge-light-success">Aktif</span>'
                            : '<span class="badge badge-light-danger">'+data+'</span>';
                    }
                },*/
                {
                    data: 'id',
                    className: "text-end",
                    orderable: false,
                    render: function(data, type, row) {

                        const isAktif = row.status_raw === 'aktif';

                        const toggleText  = isAktif ? 'Nonaktifkan' : 'Aktifkan';
                        const toggleColor = isAktif ? 'text-danger' : 'text-success';
                        const toggleValue = isAktif ? 'nonaktif' : 'aktif';

                        return `
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>

                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                                            menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4"
                                     data-kt-menu="true">

                                    <div class="menu-item px-3">
                                        <a href="#"
                                           class="menu-link px-3 btn-toggle-status ${toggleColor}"
                                           data-id="${data}"
                                           data-status="${toggleValue}">
                                            ${toggleText}
                                        </a>
                                    </div>

                                </div>
                                `;
                                            }
                                        }

            ],
            order: [[0, 'asc']]
        });

        // 🔍 Search
        $('#searchInput').on('keyup', function () {
            table.search(this.value).draw();
        });

        // 🔄 Reinit dropdown setiap draw
        $('#table_perusahaan').on('draw.dt', function () {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
        });

        // 🔁 Toggle status via AJAX
        $(document).on('click', '.btn-toggle-status', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            $.ajax({
                url: "{{ route('perusahaan.toggleStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(res) {
                    // 🔥 Toast sukses
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Status berhasil diubah ke: ' + res.status,
                        showConfirmButton: false,
                        timer: 2000
                    });
                    table.ajax.reload(null, false);
                },
                error: function() {
                    alert("Gagal mengubah status.");
                }
            });
        });

    });
</script>
