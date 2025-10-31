
<script>
    $(document).ready(function () {
        // ✅ Gunakan base URL dari Blade (otomatis sesuai konfigurasi Laravel)
        const baseUrl = "{{ url('/') }}";
        // Simpan role user ke dalam variabel JS
        const userRole = "{{ Auth::user()->getRoleNames()->first() }}";

        let table = $('#dataLamaran').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: `${baseUrl}/app/lamaran`, // gunakan baseUrl
                type: 'GET',
                data: function (d) {
                    d.status = $('[data-kt-ecommerce-product-filter="status"]').val(); // kirim status ke server
                }
            },
            columns: [
                { data: 'pelamar', name: 'pelamar' },
                { data: 'lowongan', name: 'lowongan' },
                { data: 'lokasi', name: 'lokasi' },
                { data: 'bidang_pekerjaan', name: 'bidang_pekerjaan' },
                { data: 'tanggal_lamaran', name: 'tanggal_lamaran' },
                { data: 'dokumen', name: 'dokumen', orderable: false, searchable: false },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        let badgeClass = 'badge-light-secondary';
                        if (data === 'diterima') badgeClass = 'badge-light-success';
                        else if (data === 'ditolak') badgeClass = 'badge-light-danger';
                        return `<span class="badge ${badgeClass} text-uppercase">${data ?? '-'}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        const baseUrl = "{{ url('/') }}";
                        let buttons = '';

                        // 🔒 Hanya role "Perusahaan" yang bisa melihat tombol action
                        if (userRole !== 'Perusahaan') {
                            return '<span class="badge bg-secondary">No Actions</span>';
                        }

                        // Jika user adalah "Perusahaan", tampilkan tombol sesuai status
                        if (data.status === 'diterima') {
                            buttons = `
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                     data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3"
                                           onclick="updateStatus(${row.id}, 'ditolak')">
                                           <i class="bi bi-x text-danger fs-2"></i> Ditolak
                                        </a>
                                    </div>
                                </div>
                            `;
                        } else if (data.status === 'ditolak') {
                            buttons = `
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                     data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3"
                                           onclick="updateStatus(${row.id}, 'diterima')">
                                           <i class="bi bi-check text-primary fs-2x"></i> Diterima
                                        </a>
                                    </div>
                                </div>
                            `;
                        } else {
                            buttons = `
                                <a href="#" class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                   data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Actions <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                     data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3"
                                           onclick="updateStatus(${row.id}, 'diterima')">
                                           <i class="bi bi-check text-primary fs-2x"></i> Diterima
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="javascript:void(0);" class="menu-link px-3"
                                           onclick="updateStatus(${row.id}, 'ditolak')">
                                           <i class="bi bi-x text-danger fs-2"></i> Ditolak
                                        </a>
                                    </div>
                                </div>
                            `;
                        }
                        return buttons;
                    }
                }

            ],
            order: [[4, 'desc']],
        });

        // ✅ Pastikan dropdown atau event dinamis aktif setelah reload
        $('#dataLamaran').on('draw.dt', function () {
            if (typeof KTMenu !== 'undefined') {
                KTMenu.createInstances();
            }
        });
        // Pencarian teks
        $('[data-kt-ecommerce-product-filter="search"]').on('keyup', function () {
            table.search(this.value).draw();
        });

        // Filter status
        $('[data-kt-ecommerce-product-filter="status"]').on('change', function () {
            table.ajax.reload();
        });
        // Fungsi ubah status lamaran
        window.updateStatus = function (id, status) {
            Swal.fire({
                title: 'Konfirmasi',
                text: `Apakah kamu yakin ingin menandai lamaran ini sebagai "${status}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${baseUrl}/app/lamaran/${id}/status`,
                        type: 'PUT',
                        data: {
                            _token: '{{ csrf_token() }}',
                            status: status
                        },
                        success: function (res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: res.message || 'Status lamaran berhasil diperbarui.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                            table.ajax.reload();
                        },
                        error: function (xhr) {
                            console.error(xhr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Terjadi kesalahan saat memperbarui status lamaran.',
                            });
                        }
                    });
                }
            });
        };
    });
</script>
