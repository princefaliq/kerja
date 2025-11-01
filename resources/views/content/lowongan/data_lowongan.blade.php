
<script>
    $(document).ready(function() {
        const table = $('#dataLowongan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('app/lowongan') }}",
                type: 'GET'
            },
            columns: [
                {
                    data: null,
                    orderable: false,
                    render: function(data, type, row) {
                        return `
                        <div class="form-check form-check-sm form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="${row.id}" />
                        </div>
                    `;
                    }
                },
                {
                    data: 'judul',
                    name: 'judul',
                    render: function(data, type, row) {
                        const baseUrl = "{{ url('/') }}/";
                        const imageUrl = row.user.avatar_url;
                        const slug = baseUrl +"lowongan-kerja/" + row.slug;
                        return `
                        <div class="d-flex align-items-center">
                            <a href="${slug}" class="symbol symbol-50px">
                                <span class="symbol-label" style="background-image:url(${imageUrl});"></span>
                            </a>
                            <div class="ms-5">
                                <a href="${slug}" target="_blank" class="text-gray-800 text-hover-primary fs-5 fw-bold">${data}</a>
                            </div>
                        </div>
                    `;
                    }
                },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'bidang_pekerjaan', name: 'bidang_pekerjaan' },
                { data: 'jenis_pekerjaan', name: 'jenis_pekerjaan' },
                { data: 'jumlah_lowongan', name: 'jumlah_lowongan' },
                { data: 'batas_lamaran', name: 'batas_lamaran' },
                {
                    data: 'status',
                    name: 'status',
                    render: function(data) {
                        return data
                            ? '<span class="badge badge-light-success">Aktif</span>'
                            : '<span class="badge badge-light-danger">Nonaktif</span>';
                    }
                },
                {
                    data: 'id',
                    name: 'id',
                    render: function(data, type, row) {
                        const baseUrl = "{{ url('/') }}";

                        const toggleText = row.status ? 'Nonaktifkan' : 'Aktifkan';
                        const toggleColor = row.status ? 'text-danger' : 'text-success';
                        const toggleStatus = row.status ? 'nonaktif' : 'aktif';

                        return `
                        <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                           data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Actions
                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                        </a>

                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600
                                    menu-state-bg-light-primary fw-semibold fs-7 w-150px py-4" data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="${baseUrl}/app/lowongan/edit/${data}" class="menu-link px-3">Edit</a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link px-3 btn-toggle-status ${toggleColor}"
                                   data-id="${data}" data-status="${toggleStatus}">
                                   ${toggleText}
                                </a>
                            </div>
                           <div class="menu-item px-3">
                                <a href="${baseUrl}/app/lowongan/qrcode/${row.slug}"
                                   target="_blank"
                                   class="menu-link px-3">QR Code</a>
                            </div>
                        </div>
                    `;
                    }
                }
            ],
            order: [[1, 'asc']]
        });

        // 🔍 Search input
        const searchInput = $('[data-kt-ecommerce-product-filter="search"]');
        searchInput.on('keyup', function () {
            table.search(this.value).draw();
        });

        // 🔄 Re-inisialisasi menu dropdown tiap redraw
        $('#dataLowongan').on('draw.dt', function () {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
        });

        // ⚙️ Toggle status via AJAX
        $(document).on('click', '.btn-toggle-status', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            $.ajax({
                url: "{{ route('lowongan.toggleStatus') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                success: function(response) {
                    table.ajax.reload(null, false);
                },
                error: function() {
                    alert('Gagal mengubah status');
                }
            });
        });
    });
</script>

