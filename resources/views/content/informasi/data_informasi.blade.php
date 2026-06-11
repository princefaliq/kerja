<script>
    $(document).ready(function() {

        const table = $('#dataInformasi').DataTable({

            processing: true,
            serverSide: true,

            ajax: {
                url: "{{ url('app/informasi') }}",
                type: 'GET',
                data: function (d) {
                    d.status = $('[data-kt-informasi-filter="status"]').val();
                }
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
                    data: 'gambar',
                    name: 'gambar',
                    orderable: false,
                    searchable: false,
                    render: function(data) {

                        if (!data) {
                            return `
                                <div class="symbol symbol-50px">
                                    <span class="symbol-label bg-light">
                                        <i class="ki-duotone ki-picture fs-2"></i>
                                    </span>
                                </div>
                            `;
                        }

                        return `
                            <div class="symbol symbol-50px">
                                <span class="symbol-label"
                                      style="background-image:url('/${data}')">
                                </span>
                            </div>
                        `;
                    }
                },

                {
                    data: 'judul',
                    name: 'judul',
                    render: function(data, type, row) {

                        return `
                            <div class="d-flex flex-column">
                                <span class="text-gray-800 fw-bold fs-6">${data}</span>
                                <small class="text-muted">${row.slug}</small>
                            </div>
                        `;
                    }
                },

                {
                    data: 'urutan',
                    name: 'urutan'
                },

                {
                    data: 'published_at',
                    name: 'published_at'
                },

                {
                    data: 'is_active',
                    name: 'is_active',
                    render: function(data) {

                        return data == 1
                            ? '<span class="badge badge-light-success">Aktif</span>'
                            : '<span class="badge badge-light-danger">Nonaktif</span>';
                    }
                },

                {
                    data: 'id',
                    orderable: false,
                    searchable: false,
                    render: function(data, type, row) {

                        const baseUrl = "{{ url('/') }}";

                        const toggleText = row.is_active
                            ? 'Nonaktifkan'
                            : 'Aktifkan';

                        const toggleColor = row.is_active
                            ? 'text-danger'
                            : 'text-success';

                        return `
                            <a href="#"
                               class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                               data-kt-menu-trigger="click"
                               data-kt-menu-placement="bottom-end">

                                Actions

                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </a>

                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded
                                        menu-gray-600 menu-state-bg-light-primary
                                        fw-semibold fs-7 w-150px py-4"
                                 data-kt-menu="true">

                                <div class="menu-item px-3">
                                    <a href="${baseUrl}/app/informasi/edit/${data}"
                                       class="menu-link px-3">
                                        Edit
                                    </a>
                                </div>

                                <div class="menu-item px-3">
                                    <a href="#"
                                       class="menu-link px-3 btn-toggle-status ${toggleColor}"
                                       data-id="${data}">
                                       ${toggleText}
                                    </a>
                                </div>

                            </div>
                        `;
                    }
                }
            ],

            order: [[3, 'asc']]
        });

        $('[data-kt-informasi-filter="search"]').on('keyup', function () {
            table.search(this.value).draw();
        });

        $('[data-kt-informasi-filter="status"]').on('change', function () {
            table.ajax.reload();
        });

        $('#dataInformasi').on('draw.dt', function () {

            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }

        });

    });
</script>
