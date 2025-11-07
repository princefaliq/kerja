@extends('master')
@section('title','Testimoni')
@section('testimoni','show')
@push('css')
    <link href="{{ url('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('toolbar')
    <div class="toolbar py-5 py-lg-5" id="kt_toolbar">
        <!--begin::Container-->
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column me-3">
                <!--begin::Title-->
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Testimoni List</h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Testimoni Management</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-600">Testimoni</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-gray-500">Testimoni List</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
            <!--begin::Actions-->

            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
@endsection
@section('content')
    <!--begin::Container-->
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card card-flush">
                <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-4">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input type="text" id="searchTestimoni" class="form-control form-control-solid w-250px ps-12"
                                   placeholder="Cari Testimoni..." />
                        </div>
                    </div>
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <div class="w-100 mw-150px">
                            <select id="filterStatus" class="form-select form-select-solid" data-control="select2"
                                    data-hide-search="true" data-placeholder="Status">
                                <option value="">Semua</option>
                                <option value="0">Menunggu</option>
                                <option value="1">Diterima</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="tabelTestimoni">
                        <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th>Pelamar</th>
                            <th>Isi Testimoni</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end::Container-->
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            let table = $('#tabelTestimoni').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.testimoni.data') }}",
                    data: function (d) {
                        d.status = $('#filterStatus').val();
                    }
                },
                columns: [
                    { data: 'pelamar', name: 'pelamar', orderable: false, searchable: false },
                    { data: 'isi', name: 'isi' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'aksi', name: 'aksi', orderable: false, searchable: false, className: 'text-end' },
                ],
                order: [[1, 'desc']],
            });

            $('#searchTestimoni').keyup(function () {
                table.search(this.value).draw();
            });

            $('#filterStatus').change(function () {
                table.ajax.reload();
            });

            // Approve/Reject
            $(document).on('click', '.btn-approve, .btn-reject', function () {
                const id = $(this).data('id');
                const is_approved = $(this).data('status');
                const action = status == 1 ? 'Menerima' : 'Menolak';

                Swal.fire({
                    title: `${action} testimoni ini?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#157347',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Batal',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post(`{{ url('app/testimoni') }}/${id}/status`, {
                            _token: '{{ csrf_token() }}',
                            is_approved: is_approved
                        }, function (res) {
                            if (res.success) {
                                Swal.fire('Berhasil!', res.message, 'success');
                                table.ajax.reload();
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush

